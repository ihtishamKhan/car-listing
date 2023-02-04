<?php
    session_start(); 

    
    // include_once './functions.php';
    include_once './conn/index.php';

    $query = "SELECT * FROM car";
    $result = mysqli_query($conn, $query);
    $cars = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
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

    <title>Home</title>
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
            <?php
                foreach ($cars as $car) {
                    ?>
                    <div class="col-6 col-md-4 col-lg-3 mt-4" >
                        <div class="card vehicle-card" style="width: 18rem;" onclick="this.querySelector('a').click(); return true;">
                            <img src="<?php echo $car['image'] ?>" class="card-img-top" alt="...">
                            <p class="price-tag">$<?php echo $car['price'] ?></p>
                            <div class="card-body car-listing p-2 pt-1">
                                <p class="mb-0 text-muted"><?php echo $car['model'] ?></p>
                                <h5 class="card-title"><?php echo $car['name'] ?></h5>
                                <div class="row">
                                    <div class="col">Condition:</div>
                                    <div class="col"><?php echo $car['condition'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col">Retail Price:</div>
                                    <div class="col">$<?php echo $car['price'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col">Stock #:</div>
                                    <div class="col"><?php echo $car['stock'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col">Mileage:</div>
                                    <div class="col"><?php echo $car['mileage'] ?></div>
                                </div>
                            </div>
                            <a href="./details.php?carId=<?php echo $car['id'] ?>"></a>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

    <!-- Boostrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>