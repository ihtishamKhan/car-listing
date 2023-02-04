<?php
    include_once './conn/index.php';
    session_start();
    // Get Id from URL query parameter
    $id = $_GET['carId'];
    // find car by id
    $sql = "SELECT * FROM car WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $car = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    // check if user is logged in
    // if yes then create or update a record in recently viewed table
    if (isset($_SESSION['user'])) {
        $userId = $_SESSION['user']['id'];
        $sql = "INSERT INTO recent_viewed (car_id, user_id) 
        VALUES ($id, $userId) 
        ON DUPLICATE KEY UPDATE updated_at=CURRENT_TIMESTAMP";
        mysqli_query($conn, $sql);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Styles -->
    <link rel="stylesheet" href="./assets/css/main.css">

    <title>Details</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">LONG of ETHENS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./">Home</a>
                    </li>
                    <?php
                        if (isset($_SESSION['user'])) {
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-warning" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-user-circle"></i>&nbsp;    <?php echo $_SESSION['user']['name'] ?> 
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="./recently-viewed.php">Recently Viewed</a></li>
                                    <li><a class="dropdown-item" href="server.php?logout='1'">Logout</a></li>
                                </ul>
                            </li>
                            <?php
                        } else {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="./authentication.php">Login/Register</a>
                                </li>
                            <?php
                        }
                    ?>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Body -->
    <div class="container">
        <div class="row">
            <div class="col-7">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="<?php echo $car['image']; ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="<?php echo $car['image']; ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="<?php echo $car['image']; ?>" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <h2>Options & Features</h2>
                <!-- create a striped list using bootsrap -->

                <ul class="list-group">

                    <li class="list-group-item list-group-item-info">Preferred Equipment Group 2LT</li>
                    <li class="list-group-item list-group-item-primary">4.10 Rear Axle Ratio</li>
                    
                    <li class="list-group-item list-group-item-info">Wheels: 17" x 8" Blade Silver Metallic Cast Alloy</li>
                    <li class="list-group-item list-group-item-primary">Cloth Seat Trim</li>
                    
                    <li class="list-group-item list-group-item-info">Heated Driver & Front Passenger Seats</li>
                    <li class="list-group-item list-group-item-primary">LT Convenience Package</li>
                    
                    <li class="list-group-item list-group-item-info">Luxury Package</li>
                    <li class="list-group-item list-group-item-primary">Radio: Chevrolet Infotainment 3 System</li>
                    
                    <li class="list-group-item list-group-item-info">3" Round Black Off-Road Step Bars (LPO)</li>
                    <li class="list-group-item list-group-item-primary">Manual Rear-Sliding Window</li>
                    
                    <li class="list-group-item list-group-item-info">Driver 6-Way Power Seat Adjuster</li>
                    <li class="list-group-item list-group-item-primary">Power Driver Lumbar Control Seat Adjuster</li>
                    
                    <li class="list-group-item list-group-item-info">Remote Vehicle Starter System</li>
                    <li class="list-group-item list-group-item-primary">Rear-Window Electric Defogger</li>
                    
                    <li class="list-group-item list-group-item-info">Single-Zone Auto Climate Control Air Conditioning</li>
                    <li class="list-group-item list-group-item-primary">Outside Heated Power-Adjustable Body-Color Mirrors</li>
                    
                    <li class="list-group-item list-group-item-info">Projector-Type Headlamps</li>
                    <li class="list-group-item list-group-item-primary">Front Fog Lamps</li>

                </ul>
            </div>
            <div class="col-5 mt-4">
                <h2>Price Details</h2>
                <hr>
                <div class="d-flex">
                    <h3>Price: </h3>
                    <h3 class="ms-3">$<?php echo $car['price']; ?></h3>
                </div>

                <div class="mt-5">
                    <span class="car-items">
                        <i class="fas fa-gas-pump icons"></i>
                    </span>
                    <span class="car-items">
                        19 MPG <br>
                        <small>City</small>
                    </span>
                    <span class="car-items">
                        25 MPG <br>
                        <small>Hwy</small>
                    </span>
                </div>
                
                <div class="mt-5">
                    <span class="car-items">
                        <!-- speedmeter icon -->
                        <i class="fas fa-tachometer-alt icons"></i>
                    </span>
                    <span class="car-items">
                        2.5L I4 DI DOHC VVT <br>
                        <small>6-Speed Automatic</small> <br>
                        <small>4D Crew Cab</small>
                    </span>
                </div>
                
                <div class="mt-5">
                    <span class="car-items">
                        <i class="fas fa-palette icons"></i>
                    </span>
                    <span class="car-items">
                    <?php echo $car['color']; ?>
                    </span>
                </div>
                
                <div class="mt-5">
                    <span class="car-items">
                        <!-- file icon -->
                        <i class="fas fa-file icons"></i>
                    </span>
                    <span class="car-items">
                        Condition: <?php echo $car['condition']; ?> <br>
                        Mileage: <?php echo $car['mileage']; ?> <br>
                        Stock: <?php echo $car['stock']; ?> <br>
                        reg_no: <?php echo $car['reg_no']; ?> <br>
                    </span>
                </div>

                

            </div>
        </div>
    </div>

    <!-- Boostrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>