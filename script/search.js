$(document).ready(function() {
  $("#searchForm").submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var selectedValue = $("#searchInput").val();
    if(selectedValue.length >= 2) {
      window.location.href = "index.php?searchKey=" + selectedValue;
    }
  });
});

$(document).ready(function() {
  $("#searchButton").click(function(e) {
    e.preventDefault();
    var selectedValue = $("#searchInput").val();
    if(selectedValue.length >= 2) {
      if(window.location.href.indexOf("index.php") > -1) {
        window.location.href = "index.php?searchKey=" + selectedValue;
      }
    }
  });
});

// Function to display search results in the dropdown menu
function displaySearchResults(results) {
  let searchResults = document.getElementById("searchResults");
  searchResults.innerHTML = "";

  if(results.length === 0) {
    searchResults.innerHTML = '<a class="dropdown-item">No results found</a>';
  }else {
    results.forEach((result) => {
      let item = document.createElement("a");
      item.classList.add("dropdown-item");
      item.textContent =
        result.item + " - " + result.brand + " - " + result.model_part_no;
      item.addEventListener("click", () => {
        searchInput.value = item.textContent;
        searchResults.classList.remove("show");
      });
      searchResults.appendChild(item);
    });
  }
}

// Function to handle search input changes
function handleSearchInput(event) {
  let searchTerm = event.target.value;
  if(searchTerm.length >= 2) {
    fetchSearchResults(searchTerm);
  }
}

// Event listener for search input changes
let searchInput = document.getElementById("searchInput");
searchInput.addEventListener("input", handleSearchInput);