<style>
    .highlighted-button {
        position: fixed;
        bottom: 10px;
        right: 10px;
        padding: 10px;
        background-color: #ff5722;
        color: #fff; /* Set text color to white */
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        animation: bounce 2s infinite;
    }

    .highlighted-button:hover {
        background-color: #d84315;
        animation: none;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        60% {
            transform: translateY(-5px);
        }
    }
</style>
    

<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-end py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©
      <script>
        document.write(new Date().getFullYear());
      </script>
      , Managed by
      <a href="https://ithut.in/" target="_blank" class="footer-link fw-bolder">IT HUT INDIA</a>
    </div>

  </div>

 
  <?php if (isset($_SESSION['TypeId']) && $_SESSION['TypeId'] == 4 && isset($_SESSION['incomplete_profile']) && $_SESSION['incomplete_profile']): ?>
        <div class="highlighted-button" id="profileButton">
            <a href="<?php echo $_SESSION['baseurl']?>profile.php" style="color:#fff">Incomplete Profile</a>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['AId'])): ?>
    <div class="highlighted-button" >
        <a href="<?php echo $_SESSION['baseurl']; ?>ulogout.php" style="color:#fff">Redirect To Admin</a>
    </div>
<?php endif; ?>

  
 
</footer>

<div id="loader">
  <div>
  <i class="fas fa-circle-notch fa-spin"></i>
  </div>
</div>

<div id="sidecard">
  <span class="before"></span>

  <div class="sidecard-container">

  </div>
</div>


<div id="filtercard">
  <span class="before"></span>

  <div class="filter-container">

  </div>
</div>




