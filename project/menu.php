<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fs-5">
        <div class="container ps-5">
            <a class="navbar-brand" href="index.php">SK Stationery</a>
            <button class="navbar-toggler color-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-dark navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end pe-5" id="navbarNavDropdown">
                <ul class="navbar-nav align-items-center color-white">
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu bg-body-tertiary">
                            <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                            <li><a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Order
                        </a>
                        <ul class="dropdown-menu bg-body-tertiary">
                            <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                            <li><a class="dropdown-item" href="order_read.php">Read Order</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product
                        </a>
                        <ul class="dropdown-menu bg-body-tertiary">
                            <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                            <li><a class="dropdown-item" href="product_read.php">Read Product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Product Category
                        </a>
                        <ul class="dropdown-menu bg-body-tertiary">
                            <li><a class="dropdown-item" href="product_category_create.php">Create Product Category</a></li>
                            <li><a class="dropdown-item" href="product_category_read.php">Read Product Category</a></li>
                        </ul>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="contact_us.php">Contact Us</a>
                    </li>
                    <li class="nav-item p-1 px-4 mx-2">
                        <a class="nav-link border border-light border-1 rounded" href="?logout=true">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>