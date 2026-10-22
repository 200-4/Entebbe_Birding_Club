<?php
$pageTitle = $pageTitle ?? 'Entebbe Birding Club — Birdwatching, Encounters & Excursions in Uganda';
$pageDescription = $pageDescription ?? "Entebbe Birding Club (EBC) is a community of passionate birders and tour guides running birdwatching excursions, bird encounters and holiday safaris across Uganda.";
$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$isHomePage = $currentPage === 'index.php' && empty($isPostsPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>

<!-- ============ TOP UTILITY BAR ============ -->
<div class="topbar">
  <div class="container">
    <div class="topbar-left">
      <span class="topbar-book">Book your experience now</span>
      <a class="topbar-phone" href="tel:+256773932345">
        <i class="fa-solid fa-phone" aria-hidden="true"></i>
        +256 768 302806
      </a>
      <a class="topbar-phone" href="tel:+256773930005">
        <i class="fa-solid fa-phone" aria-hidden="true"></i>
        +256 700 603938
      </a>
    </div>
    <div class="topbar-social">
      <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
      <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
      <a href="#" aria-label="X"><i class="fa-brands fa-x" aria-hidden="true"></i></a>
    </div>
  </div>
</div>

<!-- ============ MAIN HEADER ============ -->
<header class="site-header">
  <div class="container">
    <a href="index.php#home" class="logo">
      <img src="images/ebc_logo_final.svg" alt="Entebbe Birding Club logo" class="logo-mark" />
    </a>

    <nav>
      <ul class="nav-list" id="navList">
        <li><a href="index.php#home" class="nav-link<?= $isHomePage ? ' active' : '' ?>">Home</a></li>
        <li><a href="<?= $isHomePage ? '#about' : 'index.php#about' ?>" class="nav-link">About Us</a></li>
        <li><a href="<?= $isHomePage ? '#guides' : 'index.php#guides' ?>" class="nav-link">Our Guides</a></li>
        <li><a href="gallery.php" class="nav-link<?= $currentPage === 'gallery.php' ? ' active' : '' ?>">Gallery</a></li>
        <li><a href="view_posts.php" class="nav-link<?= $currentPage === 'view_posts.php' || !empty($isPostsPage) ? ' active' : '' ?>">Posts</a></li>
        <li><a href="<?= $isHomePage ? '#guides' : 'index.php#guides' ?>" class="nav-link">Our Corporate Members</a></li>
      </ul>
    </nav>

    <div class="header-actions">
      <a href="<?= $isHomePage ? '#contact' : 'index.php#contact' ?>" class="btn btn--gold desktop-only">View Our Report</a>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>
