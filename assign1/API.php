<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>API Tester – Portfolio Project</title>
    <link rel="stylesheet" href="css/API.css">
</head>
<body>
    <!--  Navigation  -->
    <header>
        <div class="nav-container">
            <h1 class="site-title">Portfolio Project</h1>
            <nav >
                <a href="index.php" >Home</a>
                <a href="about.php" >About</a>
                <a href="API.php" >API tester</a>
                
            </nav>
        </div>
    </header>

    
    <main class="container">
        <h2>API Tester</h2>

        <!-- API examples -->
        <section class="api-section">
            <h3>Company APIs</h3>
            <ul>
                <li><a href="api/companies.php" >All Companies</a></li>
                <li><a href="api/companies.php?ref=MMM" >Company by Symbol (MMM)</a></li>
            </ul>
        </section>

        <section class="api-section">
            <h3>Portfolio APIs</h3>
            <ul>
                <li><a href="api/portfolio.php?userid=1" >Portfolio for User #1</a></li>
                <li><a href="api/portfolio.php?userid=2" >Portfolio for User #2</a></li>

            </ul>
        </section>

        <section class="api-section">
            <h3>History APIs</h3>
            <ul>
                <li><a href="api/history.php?ref=MMM" >History for 3M (MMM)</a></li>
                <li><a href="api/history.php?ref=AAPL" >History for Apple (AAPL)</a></li>
            </ul>
        </section>

        
    </main>
</body>
</html>
