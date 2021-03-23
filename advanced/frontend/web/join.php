<?php
/*
 *
 * PDF merge starter:
 * Merge pages from multiple PDF documents; interactive elements (e.g.
 * bookmarks) will be dropped.
 *
 * required software: PDFlib+PDI/PPS 9
 * required data: PDF documents
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(__FILE__,3)."/input";
$outfilename = "";

$pdffiles = array(
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\1.pdf',
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\2.pdf',
    'E:\OpenServer\domains\lk\advanced\frontend\web\uploads\3.pdf'
);

try {
    $p = new PDFlib();


    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");
    $p->set_option("stringformat=utf8");

    $p->set_option("searchpath={" . $searchpath . "}");

    if ($p->begin_document($outfilename, "") == 0) {
        echo("Error: " . $p->get_errmsg());
        exit(1);
    }

    $p->set_info("Creator", "PDFlib Cookbook");
    $p->set_info("Title", "Starter PDF Merge");

    foreach ($pdffiles as $pdffile) {
        /* Open the input PDF */
        $indoc = $p->open_pdi_document($pdffile, "");
        if ($indoc == 0) {
            printf("Error: %s\n", $p->get_errmsg());
            continue;
        }

        $endpage = $p->pcos_get_number($indoc, "length:pages");

        /* Loop over all pages of the input document */
        for ($pageno = 1; $pageno <= $endpage; $pageno++) {
            $page = $p->open_pdi_page($indoc, $pageno, "");

            if ($page == 0) {
                printf("Error: %s\n", $p->get_errmsg());
                continue;
            }
            /* Page size may be adjusted by fit_pdi_page() */
            $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

            /* Create a bookmark with the file name */
//            if ($pageno == 1) {
//                $p->create_bookmark($pdffile, "");
//            }

            /* Place the imported $page on the output $page, and
             * adjust the $page size
             */
            $p->fit_pdi_page($page, 0, 0, "adjustpage");
            $p->close_pdi_page($page);

            $p->end_page_ext("");
        }
        $p->close_pdi_document($indoc);
    }

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfmerge.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    echo("PDFlib exception occurred in starter_pdfmerge sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
    exit(1);
}
catch (Exception $e) {
    echo($e);
    exit(1);
}

$p = 0;
