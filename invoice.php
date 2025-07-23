<?php
// (A) LOAD INVOICR
require "invlib/invoicr.php";

// (B) SET INVOICE DATA
// (B1) COMPANY INFORMATION
/* RECOMMENDED TO JUST PERMANENTLY CODE INTO INVLIB/INVOICR.PHP > (C1)
$invoicr->set("company", [
	"http://localhost/code-boxx-logo.png",
	"D:/http/code-boxx-logo.png",
	"Code Boxx",
	"Street Address, City, State, Zip",
	"Phone: xxx-xxx-xxx | Fax: xxx-xxx-xxx",
	"https://code-boxx.com",
	"doge@code-boxx.com"
]); */

$invoicr->set("company", [
	"./images/logo1.png",
	"D:/http/code-boxx-logo.png",
	"Dela Paz National High School",
	"Library Services"
	
]);

// (B2) INVOICE HEADER
$invoicr->set("head", [
	// ["Invoice #", "CB-123-456"],
	// ["DOP", "2011-11-11"],
	// ["P.O. #", "CB-789-123"],
	["Date Borrowed", date("Y-m-d")],
	["Return Date", $returndate]
]);

// (B3) BILL TO
$invoicr->set("billto", [
	ucwords($borrowername),
	$lrn
]);

// (B4) SHIP TO
// $invoicr->set("shipto", [
// 	"Customer Name",
// 	"Street Address",
// 	"City, State, Zip"
// ]);

// (B5) ITEMS - ADD ONE-BY-ONE
$items = [
	["$book", "", "", "", "₱$fine"],
	
];
// foreach ($items as $i) { $invoicr->add("items", $i); }

// (B6) ITEMS - OR SET ALL AT ONCE
$invoicr->set("items", $items);

// (B7) TOTALS
$invoicr->set("totals", [
	["TOTAL FINE (if returned late)", " ₱$fine"]
]);

// (B8) NOTES, IF ANY
$invoicr->set("notes", [
	"Thank you for borrowing book with us.",
	"Please return the book on time to avoid fine."
]);

// (C) OUTPUT
// (C1) CHOOSE A TEMPLATE
// $invoicr->template("apple");
// $invoicr->template("banana");
$invoicr->template("blueberry");
// $invoicr->template("lime");
// $invoicr->template("simple");
// $invoicr->template("strawberry");

// (C2) OUTPUT IN HTML
// DEFAULT : DISPLAY IN BROWSER
// 1 : DISPLAY IN BROWSER
// 2 : FORCE DOWNLOAD
// 3 : SAVE ON SERVER
// 4 : DISPLAY IN BROWSER & SAVE AS PNG
// $invoicr->outputHTML();
// $invoicr->outputHTML(1);
// $invoicr->outputHTML(2, "invoice.html");
// $invoicr->outputHTML(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.html");
// $invoicr->outputHTML(4, "invoice.png");

// (C3) OUTPUT IN PDF
// DEFAULT : DISPLAY IN BROWSER
// 1 : DISPLAY IN BROWSER
// 2 : FORCE DOWNLOAD
// 3 : SAVE ON SERVER
// $invoicr->outputPDF();
// $invoicr->outputPDF(1);
// $invoicr->outputPDF(2, "invoice.pdf");
$invoicr->outputPDF(3, __DIR__ . DIRECTORY_SEPARATOR . "receipt/receipt.pdf");

// (C4) OUTPUT IN DOCX
// DEFAULT : FORCE DOWNLOAD
// 1 : FORCE DOWNLOAD
// 2 : SAVE ON SERVER
// $invoicr->outputDOCX();
// $invoicr->outputDOCX(1, "invoice.docx");
// $invoicr->outputDOCX(2, __DIR__ . DIRECTORY_SEPARATOR . "invoice.docx");

// (D) USE RESET() IF YOU WANT TO CREATE ANOTHER ONE AFFTER THIS
// $invoicr->reset();