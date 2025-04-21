<div class="sidebar">
    <ul class="sidebar--items">
        <li>
            <a href="home">
                <span class="icon icon-1"><i class="ri-layout-grid-line"></i></span>
                <span class="sidebar--item">لوحة التحكم</span>
            </a>
        </li>
        <li>
            <a href="manage-course">
                <span class="icon icon-1"><i class="ri-file-text-line"></i></span>
                <span class="sidebar--item">إدارة التخصصات</span>
            </a>
        </li>
        <li>
            <a href="create-venue">
                <span class="icon icon-1"><i class="ri-map-pin-line"></i></span>
                <span class="sidebar--item" style="white-space: nowrap;">إضافة قاعات</span>
            </a>
        </li>
        <li>
            <a href="manage-lecture">
                <span class="icon icon-1"><i class="ri-user-line"></i></span>
                <span class="sidebar--item">إدارة الدكاترة</span>
            </a>
        </li>
        <li>
            <a href="manage-students">
                <span class="icon icon-1"><i class="ri-user-line"></i></span>
                <span class="sidebar--item">إدارة الطلاب</span>
            </a>
        </li>

    </ul>
    <ul class="sidebar--bottom-items">
        <li>
            <a href="#">
                <span class="icon icon-2"><i class="ri-settings-3-line"></i></span>
                <span class="sidebar--item">الضبط</span>
            </a>
        </li>
        <li>
            <a href="logout">
                <span class="icon icon-2"><i class="ri-logout-box-r-line"></i></span>
                <span class="sidebar--item">تسجيل الخروج</span>
            </a>
        </li>
    </ul>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentUrl = window.location.href;
        var links = document.querySelectorAll('.sidebar a');
        links.forEach(function(link) {
            if (link.href === currentUrl) {
                link.id = 'active--link';
            }
        });
    });
</script>