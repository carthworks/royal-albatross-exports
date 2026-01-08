# Royal Albatross Exports - PHP Website
## Ready for Namecheap Hosting

---

## 🎯 Quick Start

1. **Upload to Namecheap cPanel**
   - File Manager → public_html
   - Upload all files

2. **Check Server**
   - Visit: `yourdomain.com/phpinfo.php?pass=royal2024`
   - Delete phpinfo.php after checking

3. **Configure Email**
   - Edit `contact-handler.php` line 25
   - Change to your domain email

4. **Test**
   - Visit your website
   - Submit contact form
   - Check email delivery

---

## 📁 File Structure

```
public_html/
├── index.php (main file)
├── contact-handler.php (form handler)
├── phpinfo.php (DELETE AFTER USE!)
├── .htaccess (server config)
├── css/
├── js/
├── assets/
└── includes/
    ├── products-section.php
    ├── testimonials-section.php
    ├── faq-section.php
    ├── contact-section.php
    ├── footer.php
    └── product-modals.php
```

---

## 🔧 Configuration

### Email Settings (contact-handler.php):
```php
'recipient_email' => 'royalalbatrossexports@gmail.com',
'from_email' => 'noreply@yourdomain.com', // UPDATE THIS
```

### HTTPS (uncomment in .htaccess when SSL active):
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## ✅ Features

- ✅ Responsive Design
- ✅ Contact Form with Email
- ✅ Auto-Reply System
- ✅ Spam Protection
- ✅ SEO Optimized
- ✅ Security Headers
- ✅ Performance Optimized
- ✅ Dark Mode Toggle

---

## 📖 Documentation

- **CONVERSION_SUMMARY.txt** - Complete conversion details
- **NAMECHEAP_DEPLOYMENT.txt** - Deployment guide

---

## 🔒 Security

**IMPORTANT:** Delete `phpinfo.php` after checking server configuration!

---

## 📞 Contact

**Email:** royalalbatrossexports@gmail.com
**Phone:** +91 94422 29082
**Website:** royalalbatrossexport.com

---

**Version:** 1.0 (PHP)
**Last Updated:** January 2026
