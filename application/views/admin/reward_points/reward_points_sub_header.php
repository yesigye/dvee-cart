<ul class="nav nav-tabs" role="tablist" style="margin-bottom:3rem">
    <a
    role="presentation"
    href="<?php echo site_url('admin/user_reward_points') ?>"
    class="nav-item nav-link <?php echo ($active == 'points') ? 'active' : '' ?>">
        Manage Reward Points
    </a>
    <a
    role="presentation"
    href="<?php echo site_url('admin/vouchers') ?>"
    class="nav-item nav-link <?php echo ($active == 'vouchers') ? 'active' : '' ?>">
        Manage Reward Vouchers
    </a>
</ul>