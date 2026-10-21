<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Barber Admin Panel</title>

    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Oswald:300,400,600"
      rel="stylesheet"
    />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
      html,
      body {
        height: 100%;
        overflow: hidden;
        background-color: #b5bcab; /* Changed from green-grey to pure dark */
        color: #f5f5f5;
      }

      body {
        display: flex;
        flex-direction: column;
        font-family: "Oswald", sans-serif;
      }

      /* HEADER */
      .navbar-header {
        padding: 20px 15px;
        background: #000;
        border-bottom: 2px solid #c9a14a;
        flex-shrink: 0;
      }

      .navbar-header h3 {
        margin: 0;
        font-size: 18px;
        letter-spacing: 2px;
        color: #f1c86d;
        text-transform: uppercase;
      }

      /* MENU CONTAINER */
      .nav-container {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        /* Hide scrollbar */
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
      .nav-container::-webkit-scrollbar {
        display: none;
      }

      .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      /* CATEGORY HEADERS */
      .menu-category {
        padding: 8px 15px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #f1c86d;
        background-color: #575656; /* Soft gold tint */
        border-radius: 4px;
        margin: 20px 0 10px 0;
      }

      /* LINKS */
      .nav-item {
        margin-bottom: 5px;
      }

      .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-radius: 6px;
        background: #1a1a1a;
        color: #ddd;
        text-decoration: none !important;
        transition: all 0.3s ease;
        border: 1px solid transparent;
      }

      .nav-link i:first-child {
        width: 25px;
        color: #f1c86d;
        font-size: 14px;
      }

      .nav-link:hover,
      .nav-link.active {
        background: #f1c86d;
        color: #000;
      }

      .nav-link:hover i,
      .nav-link.active i {
        color: #000;
      }

      /* SUBMENU LOGIC */
      .submenu {
        list-style: none;
        padding: 0;
        margin: 5px 0 10px 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
      }
      .submenu.show {
        max-height: 200px;
      }

      .submenu-link {
        display: flex;
        align-items: center;
        padding: 10px 15px 10px 40px;
        font-size: 13px;
        color: #1a1919;
        text-decoration: none !important;
        transition: 0.2s;
        border-bottom: 2px solid #1a1919;
        border-radius: 10px;
        margin: 2px;
      }

      .submenu-link:hover {
        background-color: #333333;
        color: #f1c86d;
        padding-left: 45px;
      }

      /* ARROW */
      .arrow {
        margin-left: auto;
        transition: 0.3s;
        font-size: 10px;
      }
      .nav-link:not(.collapsed) .arrow {
        transform: rotate(180deg);
      }

      /* LOGOUT */
      .logout-section {
        padding: 15px;
        background: #000;
        border-top: 1px solid #333;
        flex-shrink: 0;
      }

      .logout-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #f1c86d, #c9a14a);
        color: #000;
        font-weight: 600;
        border: none;
        border-radius: 4px;
      }
    </style>
  </head>

  <body>
    <section class="nav-container">
      <ul class="nav-menu">
        <li class="menu-category">Customer Management</li>
        <li class="nav-item">
          <a href="#" target="RightFrame" class="nav-link collapsed" data-toggle="submenu" data-target="#customersSub">
            <i class="fa fa-users"></i> Customers <i class="fa fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu" id="customersSub">
            <li><a href="new_form_customer.php" target="RightFrame" class="submenu-link">New Customers</a></li>
            <li><a href="customerHistoryView.php" target="RightFrame" class="submenu-link">Update Customers</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link collapsed" data-toggle="submenu" data-target="#servicesSub">
            <i class="fa fa-scissors"></i> Services <i class="fa fa-chevron-down arrow"></i>
          </a>
          <ul class="submenu" id="servicesSub">
            <li><a href="new_form_AddService.php" target="RightFrame" class="submenu-link">New Service</a></li>
            <li><a href="serviceHistoryView.php" target="RightFrame" class="submenu-link">Update Service</a></li>
          </ul>
        </li>
    
        <li class="menu-category">Records</li>
        <li class="nav-item">
          <a href="serviceHistoryView.php" target="RightFrame" class="nav-link">
            <i class="fa fa-history"></i> Service List
          </a>
        </li>
        <li class="nav-item">
          <a href="paymentHistoryView.php" target="RightFrame" class="nav-link">
            <i class="fa fa-credit-card"></i> Payment History
          </a>
        </li>
    
        <li class="menu-category">Tools</li>
        <li class="nav-item">
          <a href="014frm_search.php" target="RightFrame" class="nav-link">
            <i class="fa fa-search"></i> Search Panel
          </a>
        </li>
      </ul>
    </section>


    <div class="logout-section">
      <a href="logout.php" target="_parent" class="btn logout-btn">
        <i class="fa fa-sign-out"></i> LOGOUT
      </a>
    </div>

    <script>
      $(document).ready(function () {
        $('[data-toggle="submenu"]').click(function (e) {
          e.preventDefault()
          var target = $(this).data("target")
          $(target).toggleClass("show")
          $(this).toggleClass("collapsed")
        })
      })
    </script>
  </body>
</html>
