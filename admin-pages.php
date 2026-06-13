<?php
/**
 * Admin Dashboard - Dynamic Page Builder
 * Manage custom subpages for Royal Albatross Exports
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php-errors.log');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ADMIN_PASSWORD = 'royal2026admin';
$pagesFile = 'data/pages.json';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin-pages.php');
    exit;
}

// Handle login
$loginError = '';
if (isset($_POST['login_password'])) {
    if ($_POST['login_password'] === $ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin-pages.php');
        exit;
    } else {
        $loginError = 'Incorrect password!';
    }
}

// Check authentication
$isAuthenticated = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Ensure data folder and file exists
if (!file_exists('data')) {
    mkdir('data', 0755, true);
}
if (!file_exists($pagesFile)) {
    file_put_contents($pagesFile, json_encode([], JSON_PRETTY_PRINT));
}

// Load current pages
$pages = json_decode(file_get_contents($pagesFile), true) ?? [];

// Messages
$successMsg = '';
$errorMsg = '';

// Handle Page Actions if Authenticated
if ($isAuthenticated) {
    
    // 1. DELETE PAGE
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['slug'])) {
        $delSlug = preg_replace('/[^a-zA-Z0-9-_]/', '', $_GET['slug']);
        if (isset($pages[$delSlug])) {
            unset($pages[$delSlug]);
            if (file_put_contents($pagesFile, json_encode($pages, JSON_PRETTY_PRINT))) {
                $_SESSION['action_msg'] = "Page deleted successfully!";
                header('Location: admin-pages.php');
                exit;
            } else {
                $errorMsg = "Failed to delete page. Check write permissions.";
            }
        } else {
            $errorMsg = "Page not found.";
        }
    }
    
    // 2. CREATE or UPDATE PAGE
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_page'])) {
        $title = trim($_POST['title']);
        $slug = preg_replace('/[^a-zA-Z0-9-_]/', '', strtolower(trim($_POST['slug'])));
        $description = trim($_POST['description']);
        $keywords = trim($_POST['keywords']);
        $content = $_POST['content']; // HTML content from Quill
        $status = $_POST['status'] === 'published' ? 'published' : 'draft';
        $originalSlug = isset($_POST['original_slug']) ? trim($_POST['original_slug']) : '';
        
        if (empty($title) || empty($slug) || empty($content)) {
            $errorMsg = "Title, URL slug, and content are required fields.";
        } else {
            // Check for slug conflicts
            $conflict = false;
            if ($slug !== $originalSlug && isset($pages[$slug])) {
                $conflict = true;
            }
            
            if ($conflict) {
                $errorMsg = "A page with URL slug '/$slug' already exists. Slugs must be unique.";
            } else {
                // If the slug changed, delete the old slug entry
                if (!empty($originalSlug) && $originalSlug !== $slug && isset($pages[$originalSlug])) {
                    unset($pages[$originalSlug]);
                }
                
                // Set page values
                $pages[$slug] = [
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                    'content' => $content,
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => (!empty($originalSlug) && isset($pages[$originalSlug]['created_at'])) ? $pages[$originalSlug]['created_at'] : date('Y-m-d H:i:s')
                ];
                
                if (file_put_contents($pagesFile, json_encode($pages, JSON_PRETTY_PRINT))) {
                    $_SESSION['action_msg'] = empty($originalSlug) ? "Page created successfully!" : "Page updated successfully!";
                    header('Location: admin-pages.php');
                    exit;
                } else {
                    $errorMsg = "Failed to save page data. Check folder permissions.";
                }
            }
        }
    }
}

// Fetch session messages
if (isset($_SESSION['action_msg'])) {
    $successMsg = $_SESSION['action_msg'];
    unset($_SESSION['action_msg']);
}

// Current action (list, create, edit)
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$editPage = null;

if ($action === 'edit' && isset($_GET['slug'])) {
    $editSlug = preg_replace('/[^a-zA-Z0-9-_]/', '', $_GET['slug']);
    if (isset($pages[$editSlug])) {
        $editPage = $pages[$editSlug];
        $editPage['slug'] = $editSlug;
    } else {
        $errorMsg = "Page to edit was not found.";
        $action = 'list';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Page Builder - Admin Dashboard</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo_1767183459166.png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Quill.js Theme CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    
    <!-- Custom Style Sheet -->
    <style>
        :root {
            --primary-green: #2d7a3e;
            --gold: #d4af37;
            --dark-green: #0f3d1f;
            --light-green: #eef7f0;
        }

        body {
            background: linear-gradient(135deg, var(--dark-green) 0%, #17542b 100%);
            min-height: 100vh;
            font-family: 'Outfit', sans-serif;
            color: #333;
            padding: 30px 15px;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            max-width: 1200px;
            margin: 0 auto;
            overflow: hidden;
        }

        .login-card {
            max-width: 450px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--dark-green) 0%, #1e6b36 100%);
            color: white;
            padding: 30px;
            border-bottom: 3px solid var(--gold);
        }

        .dashboard-header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dashboard-header h1 i {
            color: var(--gold);
        }

        .dashboard-body {
            padding: 35px;
        }

        .btn-custom-primary {
            background-color: var(--primary-green);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom-primary:hover {
            background-color: var(--dark-green);
            color: white;
            transform: translateY(-2px);
        }

        .btn-custom-gold {
            background-color: var(--gold);
            color: var(--dark-green);
            border: none;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom-gold:hover {
            background-color: #c49d2c;
            color: var(--dark-green);
            transform: translateY(-2px);
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: var(--light-green);
            color: var(--dark-green);
            font-weight: 700;
        }

        .table th {
            padding: 15px;
            border-bottom: 2px solid #cbd5e1;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .badge-published {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .badge-draft {
            background-color: #fef3c7;
            color: #92400e;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
        }

        /* Editor Height */
        #editor-container {
            height: 350px;
            background: white;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        
        .ql-toolbar {
            background: #f8fafc;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 8px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(45, 122, 62, 0.25);
        }

        .brand-logo-small {
            height: 40px;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <!-- 1. LOGIN SCREEN -->
    <?php if (!$isAuthenticated): ?>
    <div class="dashboard-card login-card mx-auto mt-5">
        <div class="dashboard-header text-center">
            <img src="assets/images/logo_1767183459166.png" alt="Royal Albatross Exports" class="brand-logo-small mb-3">
            <h1 class="justify-content-center"><i class="fas fa-lock"></i> Page Builder Admin</h1>
            <p class="text-white-50 mb-0 mt-1 small">Authentication required to manage pages</p>
        </div>
        <div class="dashboard-body">
            <?php if (!empty($loginError)): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-3 small d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $loginError; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label for="login_password" class="form-label">Admin Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                        <input type="password" name="login_password" id="login_password" class="form-control border-start-0 bg-light" placeholder="Enter password" required autofocus>
                    </div>
                </div>
                <button type="submit" class="btn btn-custom-primary w-100 py-2.5">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to Dashboard
                </button>
            </form>
        </div>
    </div>

    <!-- 2. MAIN ADMIN DASHBOARD -->
    <?php else: ?>
    <div class="dashboard-card">
        <!-- Dashboard Header -->
        <div class="dashboard-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1>
                    <img src="assets/images/logo_1767183459166.png" alt="Logo" class="brand-logo-small me-2">
                    Royal Page Builder
                </h1>
                <p class="text-white-50 mb-0 mt-1 small">Create, edit and manage custom landing pages and static exports content</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="admin-visitor-logs.php" class="btn btn-outline-light btn-sm border-0">
                    <i class="fas fa-chart-line me-1"></i> Visitor Logs
                </a>
                <a href="security-dashboard.php" class="btn btn-outline-light btn-sm border-0">
                    <i class="fas fa-shield-alt me-1"></i> Security Dashboard
                </a>
                <a href="?logout=1" class="btn btn-custom-gold btn-sm px-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>

        <!-- Dashboard Body -->
        <div class="dashboard-body">
            
            <!-- Success/Error Alerts -->
            <?php if (!empty($successMsg)): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $successMsg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($errorMsg)): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $errorMsg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- ACTION: LIST PAGES -->
            <?php if ($action === 'list'): ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h5 fw-bold text-dark mb-0">Custom Pages (<?php echo count($pages); ?>)</h2>
                    <a href="?action=create" class="btn btn-custom-primary">
                        <i class="fas fa-plus me-1"></i> Create New Page
                    </a>
                </div>

                <?php if (empty($pages)): ?>
                    <div class="text-center py-5 border rounded-4 bg-light">
                        <i class="fas fa-file-alt text-muted fa-3x mb-3"></i>
                        <p class="text-muted">No custom pages created yet. Click "Create New Page" to start.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover bg-white align-middle">
                            <thead>
                                <tr>
                                    <th>Page Title</th>
                                    <th>URL Path</th>
                                    <th>SEO Metadata</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pages as $pSlug => $pData): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($pData['title']); ?></div>
                                        <small class="text-muted"><?php echo htmlspecialchars($pSlug); ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo htmlspecialchars($pSlug); ?>" target="_blank" class="text-success text-decoration-none">
                                            /<?php echo htmlspecialchars($pSlug); ?> <i class="fas fa-external-link-alt ms-1 small"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($pData['description']); ?>">
                                            <small class="text-muted"><strong>Desc:</strong> <?php echo htmlspecialchars($pData['description'] ?: '-'); ?></small>
                                        </div>
                                        <div class="text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($pData['keywords']); ?>">
                                            <small class="text-muted"><strong>Keys:</strong> <?php echo htmlspecialchars($pData['keywords'] ?: '-'); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (($pData['status'] ?? 'draft') === 'published'): ?>
                                            <span class="badge-published"><i class="fas fa-check me-1"></i> Published</span>
                                        <?php else: ?>
                                            <span class="badge-draft"><i class="fas fa-edit me-1"></i> Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo date('Y-m-d H:i', strtotime($pData['updated_at'])); ?></small>
                                    </td>
                                    <td class="text-end">
                                        <a href="?action=edit&slug=<?php echo urlencode($pSlug); ?>" class="btn btn-outline-primary btn-sm me-1" title="Edit Page">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <a href="?action=delete&slug=<?php echo urlencode($pSlug); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete the page \'<?php echo addslashes($pData['title']); ?>\'? This action is permanent.');" title="Delete Page">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            <!-- ACTION: CREATE OR EDIT PAGE -->
            <?php elseif ($action === 'create' || $action === 'edit'): 
                $isEditing = ($action === 'edit');
                $formTitle = $isEditing ? "Edit Custom Page" : "Create Custom Page";
                $btnText = $isEditing ? "Update Page" : "Publish Page";
            ?>
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                    <h2 class="h4 fw-bold text-dark mb-0"><?php echo $formTitle; ?></h2>
                    <a href="admin-pages.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <form method="POST" id="pageForm">
                    <input type="hidden" name="save_page" value="1">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="original_slug" value="<?php echo htmlspecialchars($editPage['slug']); ?>">
                    <?php endif; ?>

                    <div class="row g-4">
                        <!-- Left Column: Primary details -->
                        <div class="col-lg-8">
                            <!-- Page Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control form-control-lg bg-light" placeholder="e.g. Export Grade Organic Coconuts" value="<?php echo htmlspecialchars($editPage['title'] ?? ''); ?>" required>
                                <div class="form-text text-muted">This serves as the main page title (H1) and browser page title.</div>
                            </div>

                            <!-- Content Editor -->
                            <div class="mb-3">
                                <label class="form-label">Page Content (Rich Text) <span class="text-danger">*</span></label>
                                <!-- Hidden input to hold dynamic HTML contents from Quill editor -->
                                <input type="hidden" name="content" id="content">
                                <div id="editor-container">
                                    <?php echo $editPage['content'] ?? ''; ?>
                                </div>
                                <div class="form-text text-muted">Use the rich text toolbar to style text, headers, lists, and links.</div>
                            </div>
                        </div>

                        <!-- Right Column: Settings & SEO -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm bg-light rounded-3 p-4">
                                <h3 class="h6 fw-bold text-dark border-bottom pb-2 mb-3">Page Configuration</h3>

                                <!-- URL Slug -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label">URL Slug <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted">/</span>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="organic-coconuts" value="<?php echo htmlspecialchars($editPage['slug'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-text text-muted">Lower-case alphanumeric, hyphens allowed. Direct URL: `royalalbatrossexports.in/slug`</div>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select bg-white">
                                        <option value="published" <?php echo (($editPage['status'] ?? 'published') === 'published') ? 'selected' : ''; ?>>Published (Live)</option>
                                        <option value="draft" <?php echo (($editPage['status'] ?? '') === 'draft') ? 'selected' : ''; ?>>Draft (Admin only preview)</option>
                                    </select>
                                </div>

                                <h3 class="h6 fw-bold text-dark border-bottom pb-2 mb-3 mt-2">SEO Optimization</h3>

                                <!-- SEO Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Meta Description</label>
                                    <textarea name="description" id="description" class="form-control bg-white" rows="3" placeholder="Sourcing export-grade organic coconuts directly from farmers in Coimbatore, India. Strict quality checks..."><?php echo htmlspecialchars($editPage['description'] ?? ''); ?></textarea>
                                    <div class="form-text text-muted small">Brief summary (150-160 chars) shown in search results.</div>
                                </div>

                                <!-- SEO Keywords -->
                                <div class="mb-3">
                                    <label for="keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" name="keywords" id="keywords" class="form-control bg-white" placeholder="organic coconuts, exports, coimbatore, agro products" value="<?php echo htmlspecialchars($editPage['keywords'] ?? ''); ?>">
                                    <div class="form-text text-muted small">Comma-separated key phrases related to the page.</div>
                                </div>

                                <hr class="my-4">

                                <button type="submit" class="btn btn-custom-primary w-100 py-2.5 mb-2">
                                    <i class="fas fa-save me-1"></i> <?php echo $btnText; ?>
                                </button>
                                <a href="admin-pages.php" class="btn btn-outline-secondary w-100 py-2">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- Bootstrap & Quill JS Library CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($action === 'create' || $action === 'edit'): ?>
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script>
            // Initialize Quill Editor
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Write your page content here...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'clean']
                    ]
                }
            });

            // Automatically slugify title on Create Page
            var titleInput = document.getElementById('title');
            var slugInput = document.getElementById('slug');
            var isEditing = <?php echo $isEditing ? 'true' : 'false'; ?>;

            if (!isEditing && titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    var title = this.value;
                    var slug = title.toLowerCase()
                                    .replace(/[^a-z0-9\s-]/g, '') // Remove non-alphanumeric chars
                                    .replace(/\s+/g, '-')         // Replace spaces with hyphens
                                    .replace(/-+/g, '-');          // Remove duplicate hyphens
                    slugInput.value = slug;
                });
            }

            // Bind Quill content back to form input before submitting
            var form = document.getElementById('pageForm');
            form.addEventListener('submit', function(e) {
                var hiddenContent = document.getElementById('content');
                // Extract HTML content from Quill container
                hiddenContent.value = quill.root.innerHTML;
                
                // Perform quick validations
                if (quill.getText().trim().length === 0) {
                    alert("Please write some content for the page.");
                    e.preventDefault();
                    return false;
                }
            });
        </script>
    <?php endif; ?>
</body>
</html>
