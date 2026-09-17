<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
if (file_exists('includes/security.php')) {
    require_once 'includes/security.php'; 
    if (function_exists('initSecurity')) {
        initSecurity();
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logo_1767183459166.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Refund &amp; Cancellation Policy | Royal Albatross Exports</title>
    <meta name="description" content="Refund and Cancellation Policy for B2B export contracts at Royal Albatross Exports, Coimbatore, India.">
    <link rel="canonical" href="https://royalalbatrossexport.com/refund-policy.php">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { font-family: 'Outfit', sans-serif; padding-top: 80px; }
        .policy-hero { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: #fff; padding-top: 140px; padding-bottom: 50px; margin-top: -80px; }
        .policy-content { padding: 60px 0; }
        .policy-content h2 { font-size: 1.4rem; font-weight: 700; margin-top: 2rem; color: #1a1a2e; border-left: 4px solid #f0a500; padding-left: 12px; }
        .policy-content h3 { font-size: 1.1rem; font-weight: 600; margin-top: 1.5rem; color: #333; }
        .policy-content p, .policy-content li { color: #555; line-height: 1.8; }
        .policy-content table { font-size: .9rem; }
        .last-updated { font-size: .85rem; color: #ccc; }
        .back-link { color: #f0a500; text-decoration: none; font-weight: 600; }
        .back-link:hover { color: #c97d00; }
        .notice-box { background: rgba(240, 165, 0, 0.08); border-left: 4px solid #f0a500; padding: 18px 20px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="assets/images/logo_1767183459166.png" alt="Royal Albatross Exports logo" class="logo-img">
      <div class="brand-info">
        <span class="brand-text">Royal Albatross Exports</span>
        <span class="brand-tagline">Trusted Quality. Fresh Exports. Global Reach</span>
      </div>
    </a>
    <a href="index.php" class="btn btn-sm btn-outline-warning ms-auto">
      <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Back to Home
    </a>
  </div>
</nav>

<div class="policy-hero">
  <div class="container">
    <h1><i class="fas fa-undo-alt me-2" aria-hidden="true"></i>Refund &amp; Cancellation Policy</h1>
    <p class="mb-1">Royal Albatross Exports &mdash; Coimbatore, Tamil Nadu, India</p>
    <p class="last-updated">Last updated: September 17, 2026</p>
  </div>
</div>

<div class="policy-content">
  <div class="container" style="max-width: 860px">
    <div class="notice-box">
      <strong>Commercial B2B Trade Notice:</strong> Royal Albatross Exports operates as an international merchant exporter of agricultural produce, fresh flowers, agro commodities, and organic goods. Transactions are conducted strictly under commercial contracts (Proforma Invoice / Purchase Order / Letter of Credit / Incoterms 2020) and are subject to Indian export regulations (DGFT / APEDA) and international maritime trade laws.
    </div>

    <p>This Refund &amp; Cancellation Policy outlines the procedures, terms, and conditions governing order cancellations, shipment modifications, quality claims, and financial settlements.</p>

    <h2>1. Order Confirmation &amp; Binding Agreement</h2>
    <p>An export order is considered legally binding once:</p>
    <ul>
      <li>A formal Proforma Invoice (PI) or Sales Contract has been signed and exchanged by both parties;</li>
      <li>The agreed advance payment is credited to our designated corporate bank account, or an operative, irrevocable Letter of Credit (LC) is confirmed by our advising bank.</li>
    </ul>

    <h2>2. Order Cancellation Policy</h2>
    <h3>2.1 Cancellation Before Procurement &amp; Processing</h3>
    <p>If an order cancellation request is submitted in writing prior to farm-level harvesting, commodity procurement, or specialized export packaging, the order may be cancelled subject to deduction of actual administrative and banking transfer charges incurred (typically 3% to 5% of the transaction value).</p>

    <h3>2.2 Cancellation After Processing &amp; Perishables</h3>
    <p>Due to the biological and perishable nature of fresh flowers, vegetables, and agro-commodities:</p>
    <ul>
      <li>Orders that have already entered the harvesting, sorting, cold-chain packing, or phytosanitary inspection stage cannot be cancelled.</li>
      <li>Custom export packaging bearing buyer-specific labels or barcodes cannot be cancelled once production has commenced.</li>
      <li>Confirmed freight bookings (Ocean container freight or Air cargo airway bills) cancelled within 72 hours of scheduled departure may be subject to carrier dead-freight penalties payable by the buyer.</li>
    </ul>

    <h2>3. Quality Verification &amp; Pre-Shipment Inspection</h2>
    <p>To ensure uncompromising quality and complete transparency:</p>
    <ul>
      <li>All export consignments undergo strict pre-dispatch quality verification, moisture grading, and phytosanitary certification by authorized Indian regulatory bodies.</li>
      <li>Buyers retain the contractual right to appoint an accredited third-party inspection agency (such as SGS, Bureau Veritas, or Intertek) at the port of loading (e.g., Chennai, Tuticorin, or Cochin Port) prior to container stuffing.</li>
      <li>Issuance of the clean Inspection Certificate and Bill of Lading (B/L) establishes contractual compliance at loading port (FOB / CIF as per applicable Incoterms).</li>
    </ul>

    <h2>4. Claims &amp; Quality Dispute Procedure</h2>
    <p>In the event of physical discrepancy or transit deterioration:</p>
    <ul>
      <li><strong>Notification Window:</strong> The buyer must inspect the consignment upon arrival at the destination port and report any deviation in writing within <strong>48 hours</strong> of customs clearance for perishable flowers/vegetables, or within <strong>7 calendar days</strong> for dry agro-commodities.</li>
      <li><strong>Documentary Evidence:</strong> The claim must be substantiated with unedited photographic/video records taken at container de-stuffing, temperature logger data (for reefer containers), and a joint inspection survey report conducted by an internationally recognized surveyor.</li>
      <li><strong>Biological Returns:</strong> Due to cross-border biosafety laws and agricultural quarantine regulations, physical return of biological products to India is legally restricted. Approved claims are settled via mutual commercial remedy.</li>
    </ul>

    <h2>5. Settlement of Validated Claims</h2>
    <p>Upon mutual validation of an eligible claim, Royal Albatross Exports will settle the dispute through one of the following methods as agreed with the buyer:</p>
    <table class="table table-bordered mt-3">
      <thead class="table-light">
        <tr>
          <th>Remedy Type</th>
          <th>Applicability</th>
          <th>Settlement Timeline</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Credit Note</strong></td>
          <td>Adjusted against immediate subsequent consignments or ongoing orders</td>
          <td>Within 5 business days</td>
        </tr>
        <tr>
          <td><strong>Replacement Consignment</strong></td>
          <td>Complementary replacement quantity dispatched in the next available shipping schedule</td>
          <td>As per next scheduled voyage / air cargo slot</td>
        </tr>
        <tr>
          <td><strong>Wire Refund / LC Adjustment</strong></td>
          <td>Direct wire transfer refund or amendment of Letter of Credit drawings</td>
          <td>Within 10 to 14 banking days (subject to RBI/FEMA outward remittance compliance)</td>
        </tr>
      </tbody>
    </table>

    <h2>6. Force Majeure &amp; Carrier Liability</h2>
    <p>Royal Albatross Exports is not liable for shipment non-delivery, spoilage, or delays resulting from events beyond reasonable operational control, including but not limited to:</p>
    <ul>
      <li>Maritime perils, vessel mechanical failures, port strikes, and carrier scheduling delays;</li>
      <li>Customs clearance holds or statutory quarantine embargoes instituted by importing countries;</li>
      <li>Acts of God, natural calamities, pandemic restrictions, or political turmoil.</li>
    </ul>
    <p>In such circumstances, claims should be lodged directly against the Marine Cargo Insurance policy underwritten for the voyage.</p>

    <h2>7. Governing Law &amp; Jurisdiction</h2>
    <p>All contracts and sales agreements shall be construed in accordance with the laws of the Republic of India. Any unresolved dispute arising out of or in connection with an export order shall be subject to the exclusive jurisdiction of the competent courts in <strong>Coimbatore, Tamil Nadu, India</strong>.</p>

    <h2>8. Contact for Claims &amp; Inquiries</h2>
    <p>For inquiries regarding order modifications or commercial claims, please contact our export documentation department:</p>
    <p>
      <strong>Royal Albatross Exports</strong><br>
      S.F.349/1, Oornaicker Thottam, Priya Gardens, Poochiyur Road,<br>
      Coimbatore &ndash; 641031, Tamil Nadu, India<br>
      &#128231; Email: <a href="mailto:info@royalalbatrossexports.in">info@royalalbatrossexports.in</a> &nbsp;|&nbsp; <a href="mailto:royalalbatrossexports@gmail.com">royalalbatrossexports@gmail.com</a><br>
      &#128222; Phone / WhatsApp: +91 94422 29082, +91 63834 24438
    </p>

    <div class="mt-5 pt-4 border-top">
      <a href="index.php" class="back-link"><i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Back to Home</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a href="privacy-policy.php" class="back-link">Privacy Policy</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a href="terms.php" class="back-link">Terms &amp; Conditions</a>
    </div>
  </div>
</div>

<footer class="footer">
  <div class="container">
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> Royal Albatross Exports. All rights reserved. | S.F.349/1, Oornaicker Thottam, Priya Gardens, Poochiyur Road, Coimbatore &ndash; 641031, Tamil Nadu, India</p>
      <p style="font-size:0.85rem; opacity:0.8; margin-top:6px;">
        <a href="privacy-policy.php" style="color:inherit">Privacy Policy</a> &nbsp;|&nbsp; 
        <a href="terms.php" style="color:inherit">Terms &amp; Conditions</a> &nbsp;|&nbsp; 
        <a href="refund-policy.php" style="color:inherit">Refund &amp; Cancellation Policy</a>
      </p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
