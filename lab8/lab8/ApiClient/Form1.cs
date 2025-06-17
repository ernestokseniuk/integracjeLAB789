using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Net.Http.Json;
using System.Text.Json;
using System.Threading.Tasks;
using System.Windows.Forms;
using ApiClient.Models;

namespace ApiClient
{
    public partial class Form1 : Form
    {
        private readonly HttpClient _httpClient;
        private string _token;
        private const string BaseUrl = "http://localhost:8080";

        public Form1()
        {
            InitializeComponent();
            _httpClient = new HttpClient();
            _httpClient.BaseAddress = new Uri(BaseUrl);
            
            // Set some default values for easier testing
            txtUsername.Text = "Andrzej";
            txtPassword.Text = "Andrzej";
        }

        private async void loginButton_Click(object sender, EventArgs e)
        {
            try
            {
                // Update status
                statusLabel.Text = "Logging in...";
                
                var request = new AuthRequest
                {
                    Username = txtUsername.Text,
                    Password = txtPassword.Text
                };

                var response = await _httpClient.PostAsJsonAsync("/api/users/authenticate", request);
                
                if (response.IsSuccessStatusCode)
                {
                    var authResponse = await response.Content.ReadFromJsonAsync<AuthResponse>();
                    _token = authResponse.Token;
                    txtToken.Text = _token;
                    
                    // Enable buttons after successful login
                    btnGetUsers.Enabled = true;
                    btnGetUserCount.Enabled = true;
                    btnGetRandomPrime.Enabled = true;
                    
                    statusLabel.Text = $"Logged in as {authResponse.Username}";
                    MessageBox.Show($"Successfully logged in as {authResponse.Username}", "Success", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                else
                {
                    statusLabel.Text = "Login failed";
                    MessageBox.Show($"Login failed: {response.ReasonPhrase}", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
            catch (Exception ex)
            {
                statusLabel.Text = "Error occurred";
                MessageBox.Show($"Error: {ex.Message}", "Exception", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private async void btnGetUsers_Click(object sender, EventArgs e)
        {
            statusLabel.Text = "Requesting users...";
            await MakeAuthenticatedRequest("/api/users", txtResults);
        }

        private async void btnGetUserCount_Click(object sender, EventArgs e)
        {
            statusLabel.Text = "Requesting user count...";
            await MakeAuthenticatedRequest("/api/users/count", txtResults);
        }

        private async void btnGetRandomPrime_Click(object sender, EventArgs e)
        {
            statusLabel.Text = "Requesting random prime...";
            await MakeAuthenticatedRequest("/api/numbers/random-prime", txtResults);
        }

        private async Task MakeAuthenticatedRequest(string endpoint, TextBox resultBox)
        {
            if (string.IsNullOrEmpty(_token))
            {
                MessageBox.Show("Please login first to get a token", "Authentication Required", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                statusLabel.Text = "Not authenticated";
                return;
            }

            try
            {
                _httpClient.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Bearer", _token);
                
                var response = await _httpClient.GetAsync(endpoint);
                
                if (response.IsSuccessStatusCode)
                {
                    var content = await response.Content.ReadAsStringAsync();
                    var formattedJson = JsonSerializer.Serialize(
                        JsonSerializer.Deserialize<object>(content), 
                        new JsonSerializerOptions { WriteIndented = true }
                    );
                    resultBox.Text = formattedJson;
                    statusLabel.Text = $"Request successful: {endpoint}";
                }
                else
                {
                    resultBox.Text = $"Request failed: {response.StatusCode} - {response.ReasonPhrase}";
                    statusLabel.Text = $"Request failed: {response.StatusCode}";
                    
                    if (response.StatusCode == System.Net.HttpStatusCode.Forbidden)
                    {
                        MessageBox.Show("You don't have permission to access this resource. Check your user roles.", 
                            "Access Denied", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                    }
                    else if (response.StatusCode == System.Net.HttpStatusCode.Unauthorized)
                    {
                        MessageBox.Show("Your token has expired or is invalid. Please login again.", 
                            "Authentication Error", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                    }
                }
            }
            catch (Exception ex)
            {
                resultBox.Text = $"Error: {ex.Message}";
                statusLabel.Text = "Error occurred";
            }
        }
    }
}
