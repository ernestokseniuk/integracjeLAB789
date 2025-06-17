using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Authentication.JwtBearer;
using System;

namespace lab8.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class NumbersController : ControllerBase
    {
        private readonly Random _random = new Random();
        
        // Prime numbers between 2-13
        private readonly int[] _primes = { 2, 3, 5, 7, 11, 13 };
        
        [HttpGet("random-prime")]
        [Authorize(Roles = "number", AuthenticationSchemes = JwtBearerDefaults.AuthenticationScheme)]
        public IActionResult GetRandomPrime()
        {
            // Get a random prime number from the array
            int randomPrime = _primes[_random.Next(0, _primes.Length)];
            
            return Ok(new { prime = randomPrime });
        }
    }
}
