using System.Collections.Generic;

namespace ApiClient.Models
{
    public class User
    {
        public int Id { get; set; }
        public string Username { get; set; }
        public List<Role> Roles { get; set; }
    }

    public class Role
    {
        public string Role_ { get; set; }
    }
}
