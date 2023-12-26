<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ url('/') }}" class="sidebar-brand">
      Amrak<span>TM</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">الرئيسية</li>
      <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">لوحة التحكم</span>
        </a>
      </li>
      <li class="nav-item nav-category">المستخدمين</li>
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#email" role="button" aria-expanded="" aria-controls="email">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">المزودين</span>
          <i class="link-arrow" href="{{url('/providers')}}" data-feather="chevron-down"></i>
        </a>
        <div class="collapse  " id="email">
          <ul class="nav sub-menu">

              <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">مستخدمين</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ url('accepted/users') }}" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">مستخدمين مقبولين</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('providers.index') }}" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">مزودين</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ url('accepted/providers') }}" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">مزودين مقبولين</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('colors.index') }}" class="nav-link">
                      <i class="link-icon" data-feather="calendar"></i>
                      <span class="link-title">ألوان</span>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('coupons.index') }}" class="nav-link">
                  <i class="link-icon" data-feather="calendar"></i>
                  <span class="link-title">الكوبونات</span>
                </a>
              </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category">العمليات</li>
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="" aria-controls="uiComponents">
          <i class="link-icon" data-feather="feather"></i>
          <span class="link-title">الخدمات</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse " id="uiComponents">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/categories') }}" class="nav-link "> {{__('cat')}} </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('services.index') }}" class="nav-link ">عرض الخدمات</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link ">مراجعات الخدمة</a>
            </li>
              <li class="nav-item">
                  <a href="{{route('availability_hours.index')}}" class="nav-link ">ساعات العمل </a>
              </li>
          </ul>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#advanced-ui" role="button" aria-expanded="" aria-controls="advanced-ui">
          <i class="link-icon" data-feather="anchor"></i>
          <span class="link-title">الحجز</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse " id="advanced-ui">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="" class="nav-link ">عرض الحجوزات</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link ">حالة الحجز</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="" aria-controls="forms">
          <i class="link-icon" data-feather="inbox"></i>
          <span class="link-title">إدارة الدفع</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse " id="forms">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="" class="nav-link ">طرق الدفع</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link ">العائدات</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#charts" role="button" aria-expanded="" aria-controls="charts">
          <i class="link-icon" data-feather="pie-chart"></i>
          <span class="link-title">الاعدادات</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse " id="charts">
          <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="{{url('/sliders')}}" class="nav-link">السلايدرات</a>
              </li>
            <li class="nav-item">
              <a href="" class="nav-link ">المستخدمين</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link ">الصلاحية</a>
            </li>

          </ul>
        </div>
      </li>



      <li class="nav-item  ">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" role="button" aria-expanded="" aria-controls="auth">
          <i class="link-icon" data-feather="unlock"></i>
          <span class="link-title">Authentication</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse  id="auth">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/auth/login') }}" class="nav-link ">Login</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/auth/register') }}" class="nav-link ">Register</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#error" role="button" aria-expanded="" aria-controls="error">
          <i class="link-icon" data-feather="cloud-off"></i>
          <span class="link-title">Error</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse " id="error">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/error/404') }}" class="nav-link ">404</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/error/500') }}" class="nav-link ">500</a>
            </li>
          </ul>
        </div>
      </li>

    </ul>
  </div>
</nav>
<nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <h6 class="text-muted mb-2">Sidebar:</h6>
    <div class="mb-3 pb-3 border-bottom">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          Light
        </label>
      </div>
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          Dark
        </label>
      </div>
    </div>
    <div class="theme-wrapper">
      <h6 class="text-muted mb-2">Light Version:</h6>
      <a class="theme-item active" href="">
        <img src="{{ url('assets/images/screenshots/light.jpg') }}" alt="light version">
      </a>
      <h6 class="text-muted mb-2">Dark Version:</h6>
      <a class="theme-item" href="">
        <img src="{{ url('assets/images/screenshots/dark.jpg') }}" alt="light version">
      </a>
    </div>
  </div>
</nav>
