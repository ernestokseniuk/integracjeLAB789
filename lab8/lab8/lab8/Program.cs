using lab8.Services.Users;
using Microsoft.AspNetCore.Authentication.JwtBearer;
using Microsoft.IdentityModel.Tokens;
using System.Text;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container
builder.Services.AddCors();
builder.Services.AddControllers();
builder.Services.AddScoped<IUserService, UserServiceImpl>();

// Configure JWT authentication
builder.Services.AddAuthentication(auth =>
{
    auth.DefaultAuthenticateScheme = JwtBearerDefaults.AuthenticationScheme;
})
.AddJwtBearer(options =>
{
    options.TokenValidationParameters = new TokenValidationParameters
    {
        ValidateIssuer = false,
        ValidateAudience = false,
        ValidateLifetime = true,
        ValidateIssuerSigningKey = true,
        IssuerSigningKey = new SymmetricSecurityKey(
            Encoding.UTF8.GetBytes(builder.Configuration["Jwt:Key"])),
        ClockSkew = TimeSpan.Zero
    };
});

// Set custom URL - bind to all interfaces for Docker
builder.WebHost.UseUrls("http://0.0.0.0:8080");

var app = builder.Build();

// Configure the HTTP request pipeline
app.UseRouting();

// Add authentication middleware
app.UseAuthentication();
app.UseAuthorization();

app.UseCors(x => x
    .AllowAnyOrigin()
    .AllowAnyMethod()
    .AllowAnyHeader());

// Add a route for the root path
app.MapGet("/", () => "Authentication API is running. Use /api/users/authenticate to get a token.");

app.UseEndpoints(endpoints =>
{
    endpoints.MapControllers();
});

app.Run();
