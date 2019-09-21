<ul class="nav nav-tabs" role="tablist" style="margin-bottom:3rem">
    <a
     role="presentation"
     href="<?php echo site_url('admin/location_types') ?>"
     class="nav-link nav-item <?php echo ($this->uri->segment(2) === 'location_types' OR $this->uri->segment(2) === 'insert_location_type') ? 'active' : '' ?>">
        Location Types
    </a>
    <a
     role="presentation"
     href="<?php echo site_url('admin/zones') ?>"
     class="nav-link nav-item <?php echo ($this->uri->segment(2) === 'zones' OR $this->uri->segment(2) === 'insert_zone') ? 'active' : '' ?>">
        Manage Zones
    </a>
</ul>