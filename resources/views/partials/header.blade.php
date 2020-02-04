<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">
      <img src="{{get_template_directory_uri()}}/images/sb-logo.png" width="237" height="36">
    </a>
    <div class="d-xs-block d-md-none">
      <i id="top-nav-burger" class="fa fa-bars nav-sm"></i>
      <i id="top-nav-quit" class="fa fa-times nav-sm hidden"></i>
    </div>

    @if (has_nav_menu('primary_navigation'))
      <nav class="nav-primary d-none d-md-block">
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      </nav>
    @endif

    <div class="nav-sm hidden d-xs-block d-md-none">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['menu_id' => 'top-nav-links']) !!}
      @endif
    </div>
  </div>
</header>
