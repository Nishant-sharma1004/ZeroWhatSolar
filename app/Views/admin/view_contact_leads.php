<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view('admin/shared/view_links'); ?>
</head>

<body>
    <?php echo view('admin/shared/view_sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Contact Leads Management</h2>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-primary"><?php echo $totalCount; ?></h4>
                            <small class="text-muted">Total Leads</small>
                        </div>
                        <i class="fas fa-envelope fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-warning"><?php echo $unreadCount; ?></h4>
                            <small class="text-muted">Unread</small>
                        </div>
                        <i class="fas fa-bell fa-2x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-success"><?php echo $todayCount; ?></h4>
                            <small class="text-muted">Today</small>
                        </div>
                        <i class="fas fa-calendar-day fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="btn-group" role="group">
                            <a href=<?php echo ADMIN_URL . "contact-leads?filter=all"; ?>
                                class="btn <?php echo $filter === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?>">All</a>
                            <a href=<?php echo ADMIN_URL . "contact-leads?filter=unread"; ?>
                                class="btn <?php echo $filter === 'unread' ? 'btn-warning' : 'btn-outline-warning'; ?>">
                                Unread <?php if ($unreadCount > 0) { ?><span
                                        class="badge bg-light text-dark"><?php echo $unreadCount; ?></span><?php } ?>
                            </a>
                            <a href=<?php echo ADMIN_URL . "contact-leads?filter=read"; ?>
                                class="btn <?php echo $filter === 'read' ? 'btn-success' : 'btn-outline-success'; ?>">Read</a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form method="GET" class="d-flex">
                            <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search leads..."
                                value="<?php echo $search; ?>">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Submissions -->
        <div class="row">
            <?php if (empty($contacts)) { ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No contact submissions found</h5>
                        <p class="text-muted">Contact leads will appear here when customers submit the contact form.</p>
                    </div>
                </div>
            <?php } else { ?>
                <?php foreach ($contacts as $contact) { ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card contact-card <?php echo $contact->status === 'unread' ? 'unread' : ''; ?>">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    <?php echo $contact->name; ?>
                                    <?php if ($contact->status === 'unread') { ?>
                                        <span class="badge bg-warning ms-2">New</span>
                                    <?php } ?>
                                </h6>
                                <small class="text-muted">
                                    <?php echo formatDate($contact->created_at, 'M j, Y g:i A'); ?>
                                </small>
                            </div>

                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>Email:</strong>
                                    <a href="mailto:<?php echo $contact->email; ?>">
                                        <?php echo $contact->email; ?>
                                    </a>
                                </div>

                                <?php if (!empty($contact->phone)) { ?>
                                    <div class="mb-2">
                                        <strong>Phone:</strong>
                                        <a href="tel:<?php echo $contact->phone; ?>">
                                            <?php echo $contact->phone; ?>
                                        </a>
                                    </div>
                                <?php } ?>

                                <?php if (!empty($contact->subject)) { ?>
                                    <div class="mb-2">
                                        <strong>Subject:</strong> <?php echo $contact->subject; ?>
                                    </div>
                                <?php } ?>

                                <?php if (isset($contact->message) && !empty($contact->message)) { ?>
                                    <div class="mb-3">
                                        <strong>Message:</strong><br>
                                        <div class="bg-light p-2 rounded">
                                            <?php echo substr($contact->message ?? '', 0, 200); ?>...
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- Additional fields from calculator or form -->
                                <?php if (!empty($contact->monthly_bill)) { ?>
                                    <div class="row text-center bg-primary bg-opacity-10 p-2 rounded">
                                        <div class="col-4">
                                            <small><strong>Monthly
                                                    Bill</strong><br>₹<?php echo $contact->monthly_bill; ?></small>
                                        </div>
                                        <?php if (!empty($contact->property_type)) { ?>
                                            <div class="col-4">
                                                <small><strong>Property</strong><br><?php echo $contact->property_type; ?></small>
                                            </div>
                                        <?php } ?>
                                        <?php if (!empty($contact->system_size)) { ?>
                                            <div class="col-4">
                                                <small><strong>System Size</strong><br><?php echo $contact->system_size; ?>kW</small>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="card-footer">
                                <div class="btn-group btn-group-sm w-100">
                                    <?php if ($contact->status === 'unread') { ?>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="mark_read">
                                            <input type="hidden" name="id" value="<?php echo $contact->id; ?>">
                                            <button type="submit" class="btn btn-outline-success">
                                                <i class="fas fa-check me-1"></i>Mark Read
                                            </button>
                                        </form>
                                    <?php } ?>

                                    <a href="mailto:<?php echo $contact->email; ?>?subject=Re: Solar Inquiry&body=Dear <?php echo $contact->name; ?>,%0A%0AThank you for your interest in Zero What Solar..."
                                        class="btn btn-outline-primary">
                                        <i class="fas fa-reply me-1"></i>Reply
                                    </a>

                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="deleteContact(<?php echo $contact->id; ?>, '<?php echo $contact->name; ?>')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this contact submission?</p>
                    <p><strong id="deleteContactName"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;" action="delete-contact" id="delete_contact">
                        <input type="hidden" name="id" id="deleteContactId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ADMIN_ASSETS_PATH . 'js/contact_lead.js?rand=' . RAND; ?>"></script>
</body>

</html>