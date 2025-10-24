<!-- إدارة الصفحة الرئيسية -->
<li class="nav-item {{ request()->is('admin/home-sections*') || request()->is('admin/home-sliders*') || request()->is('admin/home-section-settings*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('admin/home-sections*') || request()->is('admin/home-sliders*') || request()->is('admin/home-section-settings*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            الصفحة الرئيسية
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.home-sections.index') }}" class="nav-link {{ request()->is('admin/home-sections*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>أقسام الصفحة</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.home-section-settings.index') }}" class="nav-link {{ request()->is('admin/home-section-settings*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>إعدادات الأقسام الثابتة</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.home-sliders.index') }}" class="nav-link {{ request()->is('admin/home-sliders*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>السلايدر الرئيسي</p>
            </a>
        </li>
    </ul>
</li>

<!-- إدارة بوابات الدفع -->
<li class="nav-item">
    <a href="{{ route('admin.payment-methods.index') }}" class="nav-link {{ request()->is('admin/payment-methods*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-credit-card"></i>
        <p>بوابات الدفع</p>
    </a>
</li>

<!-- إدارة تقييمات المنتجات -->
<li class="nav-item">
    <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->is('admin/reviews*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>تقييمات المنتجات</p>
    </a>
</li>

<!-- إدارة آراء العملاء عن المتجر -->
<li class="nav-item">
    <a href="{{ route('admin.site-reviews.index') }}" class="nav-link {{ request()->is('admin/site-reviews*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-comments"></i>
        <p>آراء العملاء</p>
    </a>
</li>

<!-- إدارة الشريط المتحرك -->
<li class="nav-item">
    <a href="{{ route('admin.marquee') }}" class="nav-link {{ request()->is('admin/marquee*') ? 'active' : '' }}">
        <i class="nav-icon ri-megaphone-line"></i>
        <p>إدارة الشريط المتحرك</p>
    </a>
</li> 