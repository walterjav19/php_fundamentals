from locust import HttpUser, task, between
import random

class UserBehavior(HttpUser):
    wait_time = between(1, 3)  # cada usuario espera entre 1 y 3 segundos

    @task(3)
    def view_users(self):
        self.client.get("/user")

    @task(2)
    def create_user(self):
        data = {
            "users[name]": f"Test{random.randint(1,1000)}",
            "users[lastname]": "Demo",
            "users[email]": f"test{random.randint(1,1000)}@example.com",
            "users[password]": "12345678",
        }
        self.client.post("/user/create", data=data, allow_redirects=True)

    @task(1)
    def edit_user(self):
        user_id = random.randint(1, 10)
        data = {
            "users[name]": f"Updated{user_id}",
            "users[lastname]": "Changed",
            "users[email]": f"updated{user_id}@example.com",
            "users[password]": "newpass123",
        }
        self.client.post(f"/user/edit/{user_id}", data=data, allow_redirects=True)

    @task(1)
    def delete_user(self):
        # Simula eliminación cambiando el estado a inactivo
        user_id = random.randint(1, 10)
        self.client.get(f"/user/delete/{user_id}", allow_redirects=True)

