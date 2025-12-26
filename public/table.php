<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Table with Search, Pagination & Export</title>

<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    input {
        padding: 6px;
        width: 250px;
        margin-bottom: 10px;
    }

    button {
        padding: 6px 10px;
        margin-right: 5px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background: #f4f4f4;
    }

    .pagination {
        margin-top: 10px;
    }

    .pagination button {
        padding: 5px 10px;
        margin-right: 5px;
    }

    .pagination button.active {
        background: #007bff;
        color: white;
    }
</style>
</head>

<body>

<h2>Users Table</h2>

<input type="text" id="searchInput" placeholder="Search...">

<br><br>

<button onclick="exportCSV()">Export CSV</button>
<button onclick="exportPDF()">Export PDF</button>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody id="tableBody"></tbody>
</table>

<div class="pagination" id="pagination"></div>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<script>
// ---------------- DATA ----------------
const data = [
    { id: 1, name: "Ali Khan", email: "ali@example.com" },
    { id: 2, name: "Sara Ahmed", email: "sara@example.com" },
    { id: 3, name: "Usman Tariq", email: "usman@example.com" },
    { id: 4, name: "Ayesha Malik", email: "ayesha@example.com" },
    { id: 5, name: "Hamza Iqbal", email: "hamza@example.com" },
    { id: 6, name: "Zain Raza", email: "zain@example.com" },
    { id: 7, name: "Hira Shah", email: "hira@example.com" },
    { id: 8, name: "Bilal Butt", email: "bilal@example.com" },
    { id: 9, name: "Ziyad Alvi", email: "ziyadalvi@example.com" },
    { id: 10, name: "Mansoor Shah", email: "mansoorshah@example.com" }
];

const rowsPerPage = 3;
let currentPage = 1;
let filteredData = [...data];

const tableBody = document.getElementById("tableBody");
const pagination = document.getElementById("pagination");
const searchInput = document.getElementById("searchInput");

// ---------------- TABLE RENDER ----------------
function renderTable() {
    tableBody.innerHTML = "";
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    filteredData.slice(start, end).forEach(row => {
        tableBody.innerHTML += `
            <tr>
                <td>${row.id}</td>
                <td>${row.name}</td>
                <td>${row.email}</td>
            </tr>
        `;
    });
}

// ---------------- PAGINATION ----------------
function renderPagination() {
    pagination.innerHTML = "";
    const totalPages = Math.ceil(filteredData.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = i === currentPage ? "active" : "";
        btn.onclick = () => {
            currentPage = i;
            renderTable();
            renderPagination();
        };
        pagination.appendChild(btn);
    }
}

// ---------------- SEARCH ----------------
searchInput.addEventListener("keyup", function () {
    const query = this.value.toLowerCase();
    filteredData = data.filter(row =>
        Object.values(row).some(value =>
            String(value).toLowerCase().includes(query)
        )
    );
    currentPage = 1;
    renderTable();
    renderPagination();
});

// ---------------- EXPORT CSV ----------------
function exportCSV() {
    let csv = "ID,Name,Email\n";

    filteredData.forEach(row => {
        csv += `${row.id},${row.name},${row.email}\n`;
    });

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");

    link.href = URL.createObjectURL(blob);
    link.download = "users.csv";
    link.click();
}

// ---------------- EXPORT PDF ----------------
function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Users Report", 14, 15);

    const tableData = filteredData.map(row => [
        row.id,
        row.name,
        row.email
    ]);

    doc.autoTable({
        head: [["ID", "Name", "Email"]],
        body: tableData,
        startY: 20
    });

    doc.save("users.pdf");
}

// Initial load
renderTable();
renderPagination();
</script>

</body>
</html>
