<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Tutor Products and Teams</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5" id="app">
        <!-- Dynamic Content will be loaded here based on the route -->
    </div>

    <script>
        const app = document.getElementById('app');
        const productAPIUrl = 'http://127.0.0.1:8000/api'; // Replace with your actual API URL
        const teamAPIUrl = 'http://127.0.0.1:8000/api'; // Replace with your actual API URL

        // Simple routes
        const routes = {
            '/': renderHome,
            '/create-product': renderCreateProduct,
            '/create-team': renderCreateTeam
        };

        // Function to handle route changes
        function navigateTo(route) {
            history.pushState({}, route, window.location.origin + route);
            renderRoute(route);
        }

        // Render the appropriate page based on the current route
        function renderRoute(route) {
            app.innerHTML = ''; // Clear current content
            const routeFunction = routes[route];
            if (routeFunction) {
                routeFunction();
            } else {
                app.innerHTML = '<h2>404 - Page Not Found</h2>';
            }
        }

        // Home Page - Display products and teams
        function renderHome() {
            app.innerHTML = `
                <h2>Welcome to the Admin Panel</h2>
                <ul>
                    <li><a href="#" onclick="navigateTo('/create-product')">Create Tutor Product</a></li>
                    <li><a href="#" onclick="navigateTo('/create-team')">Create Team</a></li>
                </ul>
                <hr>
                <h3>Tutor Products</h3>
                <ul id="product-list"></ul>
                <hr>
                <h3>Teams</h3>
                <ul id="team-list"></ul>
            `;
            fetchProducts();
            fetchTeams();
        }

        // Fetch and display products in a table
        function fetchProducts() {
            fetch(`${productAPIUrl}/get-products`)
                .then(response => response.json())
                .then(data => {
                    const productList = document.getElementById('product-list');
                    productList.innerHTML = ''; // Clear existing content
                    
                    // Create the table
                    const table = document.createElement('table');
                    table.classList.add('table', 'table-bordered', 'table-striped');
                    
                    // Table header
                    const tableHeader = document.createElement('thead');
                    tableHeader.innerHTML = `
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    `;
                    table.appendChild(tableHeader);

                    // Table body
                    const tableBody = document.createElement('tbody');
                    data.forEach((product, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${product.title}</td>
                            <td>${product.description}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });

                    table.appendChild(tableBody);
                    productList.appendChild(table);
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    alert('Error fetching products!');
                });
        }

        // Fetch and display teams in a table
        function fetchTeams() {
            fetch(`${teamAPIUrl}/get-teams`)
                .then(response => response.json())
                .then(data => {
                    const teamList = document.getElementById('team-list');
                    teamList.innerHTML = ''; // Clear existing content
                    
                    // Create the table
                    const table = document.createElement('table');
                    table.classList.add('table', 'table-bordered', 'table-striped');
                    
                    // Table header
                    const tableHeader = document.createElement('thead');
                    tableHeader.innerHTML = `
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    `;
                    table.appendChild(tableHeader);

                    // Table body
                    const tableBody = document.createElement('tbody');
                    data.forEach((team, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${team.name}</td>
                            <td>${team.contact}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteTeam(${team.id})">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });

                    table.appendChild(tableBody);
                    teamList.appendChild(table);
                })
                .catch(error => {
                    console.error('Error fetching teams:', error);
                    alert('Error fetching teams!');
                });
        }


        // Create Product Page
        function renderCreateProduct() {
            app.innerHTML = `
                <h2>Create Tutor Product</h2>
                <form id="product-form">
                    <div class="mb-3">
                        <label for="product-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="product-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="product-description" class="form-label">Description</label>
                        <textarea class="form-control" id="product-description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                </form>
                <hr>
                <button class="btn btn-secondary" onclick="navigateTo('/')">Go Home</button>
            `;

            document.getElementById('product-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const title = document.getElementById('product-title').value;
                const description = document.getElementById('product-description').value;

                const data = { title, description };

                fetch(`${productAPIUrl}/save-products`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    alert('Product Created Successfully!');
                    navigateTo('/');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error creating product!');
                });
            });
        }

        // Create Team Page
        function renderCreateTeam() {
            app.innerHTML = `
                <h2>Create Team</h2>
                <form id="team-form">
                    <div class="mb-3">
                        <label for="team-name" class="form-label">Team Name</label>
                        <input type="text" class="form-control" id="team-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="team-contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="team-contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="team-website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="team-website" required>
                    </div>
                    <div class="mb-3">
                        <label for="team-tutor-product" class="form-label">Tutor Product ID</label>
                        <input type="text" class="form-control" id="team-tutor-product" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Team</button>
                </form>
                <hr>
                <button class="btn btn-secondary" onclick="navigateTo('/')">Go Home</button>
            `;

            document.getElementById('team-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const name = document.getElementById('team-name').value;
                const contact = document.getElementById('team-contact').value;
                const website = document.getElementById('team-website').value;
                const tutorProductId = document.getElementById('team-tutor-product').value;

                const data = { tutor_product_id: tutorProductId, name, contact, website };

                fetch(`${teamAPIUrl}/save-teams`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    alert('Team Created Successfully!');
                    navigateTo('/');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error creating team!');
                });
            });
        }

        // Delete Product
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`${productAPIUrl}/drop-products/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    alert('Product deleted successfully!');
                    fetchProducts();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product!');
                });
            }
        }

        // Delete Team
        function deleteTeam(id) {
            if (confirm('Are you sure you want to delete this team?')) {
                fetch(`${teamAPIUrl}/drop-teams/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    alert('Team deleted successfully!');
                    fetchTeams();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting team!');
                });
            }
        }

        // Initial route load
        window.addEventListener('popstate', () => {
            renderRoute(window.location.pathname);
        });

        // Start at the home route
        navigateTo('/');
    </script>
</body>
</html>
