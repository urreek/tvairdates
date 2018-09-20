<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <form class="form-inline my-2 my-lg-0 d-sm-none">
    <input class="form-control mr-sm-2" onKeyUp="showResult(this.value)" type="text" placeholder="Search" aria-label="Search">
  </form>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?php if($request_uri == 'new-shows') echo 'active'; ?>" href="/new-shows">New Shows</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if($request_uri  == 'popular-shows') echo 'active'; ?>" href="/popular-shows">Popular Shows</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if($request_uri  == 'top-shows') echo 'active'; ?>" href="/top-shows">Top Shows</a>
      </li>
    </ul>
  </div>
  <form class="form-inline d-none d-sm-block">
    <input class="form-control" onKeyUp="showResult(this.value)" type="text" placeholder="Search" aria-label="Search">
  </form>
  <div class="search_results"></div>
</nav>
