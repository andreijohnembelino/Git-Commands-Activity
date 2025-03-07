<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>Inventory Report</h1>
        <div class="card shadow-sm">
             <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="card-title">Generate Inventory Report</h5>
                    <button class="btn btn-primary" onclick="window.print()">Print Report</button>
                </div>
             <div class="card-body">
                   <!-- Filter Options -->
                    <form id="inventoryReportFilterForm">
                           <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="filterName" class="form-label">Item Name</label>
                                    <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter Item Name">
                                 </div>
                                  <div class="col-md-4">
                                   <label for="filterCategory" class="form-label">Category</label>
                                    <select class="form-select" id="filterCategory" name="filterCategory">
                                        <option value="">All</option>
                                          <option value="medicine">Medicine</option>
                                          <option value="supply">Supply</option>
                                           <option value="equipment">Equipment</option>
                                      </select>
                                 </div>
                                   <div class="col-md-4">
                                      <label for="filterLowStock" class="form-label">Low Stock</label>
                                     <select class="form-select" id="filterLowStock" name="filterLowStock">
                                         <option value="">All</option>
                                          <option value="true">Yes</option>
                                           <option value="false">No</option>
                                    </select>
                                  </div>
                           </div>
                            <div class="row g-3 mb-3">
                                 <div class="col-md-4">
                                    <label for="filterStartDate" class="form-label">Start Date</label>
                                     <input type="date" class="form-control" id="filterStartDate" name="filterStartDate">
                                   </div>
                                   <div class="col-md-4">
                                     <label for="filterEndDate" class="form-label">End Date</label>
                                     <input type="date" class="form-control" id="filterEndDate" name="filterEndDate">
                                   </div>
                                 <div class="col-md-4 d-flex align-items-end">
                                      <button type="submit" class="btn btn-secondary  w-100" id="applyFiltersButton">Apply Filters</button>
                                  </div>
                            </div>
                    </form>
             </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                 <th>Total Value</th>
                            </tr>
                        </thead>
                         <tbody id="inventory-report-body">
                           <tr>
                              <td>101</td>
                                <td>Paracetamol</td>
                                <td>Medicine</td>
                                <td>500</td>
                                <td>5.00</td>
                                  <td>2500.00</td>
                            </tr>
                           <tr>
                                 <td>102</td>
                                <td>Syringes</td>
                                <td>Supply</td>
                                <td>1000</td>
                                 <td>1.00</td>
                                 <td>1000.00</td>
                            </tr>
                            <tr>
                                <td>103</td>
                                <td>Stethoscope</td>
                                <td>Equipment</td>
                                <td>50</td>
                                <td>50.00</td>
                                 <td>2500.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // handle filter form
    document.getElementById('inventoryReportFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

          // Get all the filter values
         const filterName = document.getElementById('filterName').value;
        const filterCategory = document.getElementById('filterCategory').value;
        const filterStartDate = document.getElementById('filterStartDate').value;
         const filterEndDate = document.getElementById('filterEndDate').value;
        const filterLowStock = document.getElementById('filterLowStock').value;

           // Prepare filter data
         const filterData = {
             filterName: filterName,
             filterCategory: filterCategory,
             filterStartDate: filterStartDate,
             filterEndDate: filterEndDate,
             filterLowStock: filterLowStock
            };
        console.log(filterData); // for debugging purposes
          // you will have to make a php api to use this data and update the content of the table, using fetch
        // for the moment we are using a console log
        alert("Filters have been applied, see console")
    });
</script>
</body>
</html>