<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>Inventory Management</h1>
        <!-- Summary Cards (Leave as is for now) -->
        <!-- <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Items</h5>
                        <p class="card-text display-6 fw-bold" id="total-items">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Medicine</h5>
                        <p class="card-text display-6 fw-bold" id="total-medicine">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Supplies</h5>
                        <p class="card-text display-6 fw-bold" id="total-supplies">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Equipment</h5>
                        <p class="card-text display-6 fw-bold" id="total-equipment">0</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Low Stock Items</h5>
                        <p class="card-text display-6 fw-bold" id="low-stock-items">0</p>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Inventory Items</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInventoryModal">Add New Item</button>
                    </div>
                    <!-- Filter Options -->
                    <div class="card-body">
                        <form id="inventoryFilterForm">
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
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-secondary  w-100" id="applyFiltersButton">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="inventory-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Inventory Modal (Leave as is for now) -->
    <div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInventoryModalLabel">Add New Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addInventoryForm" method="post" action="">
                        <div class="mb-3">
                            <label for="itemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemCategory" class="form-label">Category</label>
                            <select class="form-select" id="itemCategory" name="itemCategory" required>
                                <option value="medicine">Medicine</option>
                                <option value="supply">Supply</option>
                                <option value="equipment">Equipment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="itemQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="itemQuantity" name="itemQuantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemUnitPrice" class="form-label">Unit Price</label>
                            <input type="number" class="form-control" id="itemUnitPrice" name="itemUnitPrice" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- view Inventory Modal (Leave as is for now) -->
    <div class="modal fade" id="viewInventoryModal" tabindex="-1" aria-labelledby="viewInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewInventoryModalLabel">View Inventory Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Item ID:</strong> <span id="view-item-id"></span></p>
                <p><strong>Item Name:</strong> <span id="view-item-name"></span></p>
                <p><strong>Category:</strong> <span id="view-category"></span></p>
                <p><strong>Quantity:</strong> <span id="view-quantity"></span></p>
                <p><strong>Unit Price:</strong> <span id="view-unit-price"></span></p>
                <p><strong>Created By:</strong> <span id="view-created-by"></span></p>
                <p><strong>Modified By:</strong> <span id="view-modified-by"></span></p>
                <p><strong>Created At:</strong> <span id="view-created-at"></span></p>
                <p><strong>Updated At:</strong> <span id="view-updated-at"></span></p>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Inventory Modal -->
    <div class="modal fade" id="editInventoryModal" tabindex="-1" aria-labelledby="editInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInventoryModalLabel">Edit Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editInventoryForm" method="post" action="">
                        <input type="hidden" id="editItemId" name="itemId">
                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="editItemName" name="itemName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemCategory" class="form-label">Category</label>
                            <select class="form-select" id="editItemCategory" name="itemCategory" required>
                                <option value="medicine">Medicine</option>
                                <option value="supply">Supply</option>
                                <option value="equipment">Equipment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editItemQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editItemQuantity" name="itemQuantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemUnitPrice" class="form-label">Unit Price</label>
                            <input type="number" class="form-control" id="editItemUnitPrice" name="itemUnitPrice" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        // Javascript implementation, You will have to implement the save data with php
        document.getElementById('addInventoryForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        // Get the data from the form
          const itemName = document.getElementById('itemName').value;
         const itemCategory = document.getElementById('itemCategory').value;
        const itemQuantity = document.getElementById('itemQuantity').value;
        const itemUnitPrice = document.getElementById('itemUnitPrice').value;
        // Prepare data
          const formData = {
            itemName: itemName,
             itemCategory: itemCategory,
            itemQuantity: itemQuantity,
            itemUnitPrice: itemUnitPrice
           };
         fetch('../api/inventory_management/add_inventory.php',{
            method: 'POST',
             headers: {
              'Content-Type': 'application/json',
             },
             body: JSON.stringify(formData)
         })
           .then(response => {
                 if (!response.ok) {
                      throw new Error('Failed to add item');
                  }
                  return response.json();
            })
            .then(data => {
              if (data.success) {
                 alert("Inventory Item Added Successfully");
                document.getElementById('inventoryFilterForm').dispatchEvent(new Event('submit'));// trigger the get fetch after add
                  const modal = document.getElementById('addInventoryModal');
                   const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
                 document.getElementById('addInventoryForm').reset();
                } else {
                 alert('Failed to add item: ' + data.message);
                 }
            })
         .catch(error => {
             console.error('Error:', error);
             alert('Failed to add item!');
           });
    });





    // Function to fetch and display inventory data
    function fetchInventoryData(filterData = {}) {
        fetch('../api/inventory_management/get_inventory.php', {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    filterData: filterData
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch inventory items');
                }
                return response.json();
            })
            .then(inventoryItems => {
                displayInventory(inventoryItems);
            })
            .catch(error => {
                console.error('Error fetching inventory items:', error);
                alert('Failed to fetch inventory items');
            });
    }

    //list items from database to table
    function displayInventory(inventoryItems) {
        const tableBody = document.getElementById('inventory-table-body');
        tableBody.innerHTML = ''; 
        inventoryItems.forEach(item => {
            const row = tableBody.insertRow();
            row.innerHTML = `
                <td>${item.item_id}</td>
                <td>${item.item_name}</td>
                <td>${item.category}</td>
                <td>${item.quantity}</td>
                <td>${item.unit_price}</td>
                <td>
                    <button class="btn btn-sm btn-info view-inventory-btn" data-bs-toggle="modal" data-bs-target="#viewInventoryModal" data-inventory-id="${item.item_id}">View</button>
                    <button class="btn btn-sm btn-primary edit-inventory-btn" data-bs-toggle="modal" data-bs-target="#editInventoryModal" data-inventory-id="${item.item_id}">Edit</button>
                </td>
            `;
        });
    }
    // Handle filter form submission
    document.getElementById('inventoryFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const filterName = document.getElementById('filterName').value;
        const filterCategory = document.getElementById('filterCategory').value;

        const filterData = {
            filterName: filterName,
            filterCategory: filterCategory
        };
        fetchInventoryData(filterData); // Fetch data with filters
    });

              // Handle edit item button clicks using javascript
              document.getElementById('inventory-table-body').addEventListener('click', function(event) {
    if (event.target.classList.contains('edit-inventory-btn')) {
        const itemId = event.target.getAttribute('data-inventory-id'); // Get item ID
        if (!itemId) {
            alert('Error: Missing item ID.');
            return;
        }

        // Ensure the hidden input field gets the correct itemId
        document.getElementById('editItemId').value = itemId;

        // Fetch item details
        fetch(`../api/inventory_management/get_item.php?itemId=${itemId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch item details');
                }
                return response.json();
            })
            .then(item => {
                document.getElementById('editItemId').value = item.item_id; // Ensure itemId is set
                document.getElementById('editItemName').value = item.item_name;
                document.getElementById('editItemCategory').value = item.category;
                document.getElementById('editItemQuantity').value = item.quantity;
                document.getElementById('editItemUnitPrice').value = item.unit_price;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch item details!');
            });
    }
});

  document.getElementById('editInventoryForm').addEventListener('submit', function(event) {
         event.preventDefault(); // Prevent the form from submitting normally
         const itemId = document.getElementById('editItemId').value; // Get value from hidden input
    if (!itemId) {
        alert('Error: Item ID is missing.');
        return;
    }// Get item id from data atribute
          const itemName = document.getElementById('editItemName').value;
          const itemCategory = document.getElementById('editItemCategory').value;
          const itemQuantity = document.getElementById('editItemQuantity').value;
           const itemUnitPrice = document.getElementById('editItemUnitPrice').value;
        // Prepare data
          const formData = {
               itemId: itemId,
             itemName: itemName,
           itemCategory: itemCategory,
           itemQuantity: itemQuantity,
             itemUnitPrice: itemUnitPrice
         };
       fetch('../api/inventory_management/edit_inventory.php', {
                method: 'POST',
               headers: {
                 'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
           })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Failed to update item');
                 }
               return response.json();
           })
            .then(data => {
                if (data.success) {
                    alert("Item updated successfully!");
                      document.getElementById('inventoryFilterForm').dispatchEvent(new Event('submit')); // trigger the get fetch
                     const modal = document.getElementById('editInventoryModal');
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                  modalInstance.hide();
               } else {
                   alert('Failed to update item: ' + data.message);
                }
           })
            .catch(error => {
                 console.error('Error:', error);
                 alert('Failed to update item!');
             });
     });

   // Handle view inventory button clicks using javascript
   document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('view-inventory-btn')) {
            const itemId = event.target.getAttribute('data-inventory-id');
            fetchInventoryItem(itemId);
        }
    });
});

function fetchInventoryItem(itemId) {
    fetch(`../api/inventory_management/get_itemView.php?item_id=${itemId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate the modal with item details
                const item = data.item;
                document.getElementById('view-item-id').textContent = item.item_id;
                document.getElementById('view-item-name').textContent = item.item_name;
                document.getElementById('view-category').textContent = item.category;
                document.getElementById('view-quantity').textContent = item.quantity;
                document.getElementById('view-unit-price').textContent = item.unit_price;
                document.getElementById('view-created-by').innerText = item.created_by_name; // Show the name
                document.getElementById('view-modified-by').innerText = item.updated_by_name; // Show the name
                document.getElementById('view-created-at').textContent = item.created_at;
                document.getElementById('view-updated-at').textContent = item.updated_at;
            } else {
                alert('Failed to retrieve item details.');
            }
        })
        .catch(error => console.error('Error:', error));
}




    // Fetch inventory data on page load (initial display)
    fetchInventoryData();
</script>
</body>

</html>