# IT-Inventory-System_BS

                                              ------DATABASE STRUCTURE------

Database: it_inventory_system_db

Tables: 
        inventorysystem_table (main)
            - id(int), item(varchar), brand(varchar), category(varchar), model_part_no(varchar), specifications(text), unit(varchar), max_stock(int), min_stock(int),           
              initial_stock(int), actual_stock(int), received(int), issued(int), ordering_point(int), for_purchase(int), location(text), supplier(text), remarks(text)
        
        category_dd (dropdown table)
            -categoryId(int), categorySelect(varchar)	
        
        location_dd (dropdown table)
            -id(int), location_select(varchar)
        
        unit_dd (dropdown table)
            -id(int), unit_select(varchar)
