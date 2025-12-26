/**
 * Table Export Utilities
 * Used by Tickets / Users / Projects tables
 * Requires jsPDF + jsPDF AutoTable
 */

/* ===========================
   EXPORT CSV
=========================== */
function exportCSV(filenamePrefix = "tickets") {
    if (!window.filteredData || !filteredData.length) {
        alert("No data available to export.");
        return;
    }

    const headers = Object.keys(filteredData[0]);
    let csv = headers.join(",") + "\n";

    filteredData.forEach(row => {
        const values = headers.map(h =>
            `"${String(row[h]).replace(/"/g, '""')}"`
        );
        csv += values.join(",") + "\n";
    });

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");

    link.href = URL.createObjectURL(blob);
    link.download = `${filenamePrefix}_${getToday()}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

/* ===========================
   EXPORT PDF (TICKETS)
=========================== */
function exportPDF() {
    if (!window.filteredData || !filteredData.length) {
        alert("No data available to export.");
        return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF("p", "mm", "a4");

    const today = getToday();

    /* -------- TITLE -------- */
    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text("Tickets Report", 105, 15, { align: "center" });

    /* -------- TABLE DATA -------- */
    const tableBody = filteredData.map(ticket => [
        "#" + ticket.id,
        ticket.title,
        formatStatus(ticket.status),
        ticket.priority,
        ticket.created_at
    ]);

    /* -------- AUTOTABLE -------- */
    doc.autoTable({
        startY: 25,
        head: [["ID", "Title", "Status", "Priority", "Created"]],
        body: tableBody,

        theme: "grid",

        styles: {
            font: "helvetica",
            fontSize: 9,
            cellPadding: 4,
            valign: "middle"
        },

        headStyles: {
            fillColor: [41, 128, 185], // Blue header
            textColor: 255,
            fontStyle: "bold"
        },

        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },

        columnStyles: {
            0: { cellWidth: 18 },  // ID
            1: { cellWidth: 65 },  // Title
            2: { cellWidth: 30 },  // Status
            3: { cellWidth: 30 },  // Priority
            4: { cellWidth: 30 }   // Created
        },

        margin: { left: 10, right: 10 }
    });

    /* -------- SAVE -------- */
    doc.save(`tickets_${today}.pdf`);
}

/* ===========================
   HELPERS
=========================== */
function getToday() {
    return new Date().toISOString().split("T")[0]; // YYYY-MM-DD
}

function formatStatus(status) {
    if (!status) return "";
    return status.replace(/_/g, " ").replace(/\b\w/g, c => c.toUpperCase());
}
