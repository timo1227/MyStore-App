<table><tr><td> <em>Assignment: </em> IT202 Milestone 2 Shop Project</td></tr>
<tr><td> <em>Student: </em> Timothy Estrada(the4)</td></tr>
<tr><td> <em>Generated: </em> 7/18/2022 2:43:30 PM</td></tr>
<tr><td> <em>Grading Link: </em> <a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-451-M22/it202-milestone-2-shop-project/grade/the4" target="_blank">Grading</a></td></tr></table>
<table><tr><td> <em>Instructions: </em> <ol><li>Checkout Milestone2 branch</li><li>Create a new markdown file called milestone2.md</li><li>git add/commit/push immediate</li><li>Fill in the below deliverables</li><li>At the end copy the markdown and paste it into milestone2.md</li><li>Add/commit/push the changes to Milestone2</li><li>PR Milestone2 to dev and verify</li><li>PR dev to prod and verify</li><li>Checkout dev locally and pull changes to get ready for Milestone 3</li><li>Submit the direct link to this new milestone2.md file from your GitHub prod branch to Canvas</li></ol><p>Note: Ensure all images appear properly on github and everywhere else. Images are only accepted from dev or prod, not local host. All website links must be from prod (you can assume/infer this by getting your dev URL and changing dev to prod).</p></td></tr></table>
<table><tr><td> <em>Deliverable 1: </em> Users with admin or shop owner will be able to add products </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshot of admin create item page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179545520-9ff41b2d-4c48-4040-b27c-4507a8f902db.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Admins Add Item Page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add screenshot of populated Products table clearly showing the columns</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179551432-297d88bf-b140-4867-8a75-6721bdf2ef8d.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Table in VS Code<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly describe the code flow for creating a Product</td></tr>
<tr><td> <em>Response:</em> <p>Once the form is submitted the information from Post is sent to DB<br>and saved one by one using the helper function save_data.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/37">https://github.com/timo1227/IT202-451-M22/pull/37</a> </td></tr>
<tr><td> <em>Sub-Task 5: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/admin/add_item.php">http://the4-prod.herokuapp.com/Project/admin/add_item.php</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 2: </em> Any user can see visible products on the Shop Page </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot of the Shop page showing 10 items without filters/sorting applied</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179554673-51adc7d9-1848-4904-b990-f6cafa367252.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Shop Page 1/2<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179554871-9318b435-adb1-4336-854a-3a713f3156f9.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Shop Page 2/2<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot of the Shop page showing both filters and a different sorting applied (should be more than 1 sample product)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179555155-10e5d5a9-d44f-4f79-bca9-4024e444b3a9.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Filter Womens<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add a screenshot of the filter/sort logic from the code</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179556161-8e40587d-9001-49cc-8465-de87628b0402.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>JS filter function i created<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179556531-cf6dfd39-2253-42eb-a6e4-8c6cfd814bef.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>PHP Logic <br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179557417-18ab061c-a3dd-4dfc-af1e-e5ba8348900c.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Sort PHP Logic<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Briefly explain how the results are shown and how the filters are applied</td></tr>
<tr><td> <em>Response:</em> <p>Since I do not list the description of the items on the Home<br>Page I created a function that will make a call to the DB<br>to that will get items with the given category and then rebuild the<br>shop page with those cards. Sort follows the same Logic but this time<br>rebuilds the page after its made a call to DB to get the<br>items in DESC or ASC order.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 5: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
<tr><td> <em>Sub-Task 6: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/home.php">http://the4-prod.herokuapp.com/Project/home.php</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 3: </em> Show Admin/Shop Owner Product List (this is not the Shop page and should show visibility status) </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Screenshot of the Admin List page/results</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179562842-89942889-936e-4a42-8b10-d524fecbef21.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Admin Shop View<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179558399-ba7cbc91-1022-4c55-ad93-ba8a3040423f.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Admin List Item<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Briefly explain how the results are shown</td></tr>
<tr><td> <em>Response:</em> <p>Admin Shop Shows all Items no matter what Current Stock is and List<br>Items shows all as well.<br></p><br></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/admin/list_items.php">http://the4-prod.herokuapp.com/Project/admin/list_items.php</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 4: </em> Admin/Shop Owner Edit button </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the edit button visible to the Admin on the Shop page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179562842-89942889-936e-4a42-8b10-d524fecbef21.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Edit Button on Admin shop View<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot showing the edit button visible to the Admin on the Product Details Page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179563717-edb38fcf-64a5-439e-be0e-ab9470e31962.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Product Page Edit Button for Admins<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add a screenshot showing the edit button visible to the Admin on the Admin Product List Page (The admin page)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179558399-ba7cbc91-1022-4c55-ad93-ba8a3040423f.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Edit Button At End of Row<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a before and after screenshot of Editing a Product via the Admin Edit Product Page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179563717-edb38fcf-64a5-439e-be0e-ab9470e31962.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Before Edit<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179564139-f940ca3b-1b28-4fd2-bd6e-aa246e2b8ca9.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>After Edit<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 5: </em> Briefly explain the code process/flow</td></tr>
<tr><td> <em>Response:</em> <p>Once Button is Pressed on Product Page the ID is sent with the<br>redirect the Edit Page then is matched to DB to fill in the<br>Data on edit form. Once Update is pressed the data is saved on<br>DB.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 6: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/37">https://github.com/timo1227/IT202-451-M22/pull/37</a> </td></tr>
<tr><td> <em>Sub-Task 7: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/admin/admin_shop.php">http://the4-prod.herokuapp.com/Project/admin/admin_shop.php</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 5: </em> Product Details Page </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the button (clickable item) that directs the user to the Product Details Page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179565629-9fcb9741-38dd-4312-8141-489e50ee8740.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Pointer is over Product Image once Pressed directs them to desired Product Page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot showing the result of the Product Details Page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179566028-1a8f7df7-c286-4679-b75b-c7b49d50c4a7.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Product Page <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly explain the code process/flow</td></tr>
<tr><td> <em>Response:</em> <p>Once the Image is Clicked By normal User the it will redirect them<br>to product page and sending the ID of the product with it so<br>once PHP gets the id it Begins to build the Page with the<br>matching ID and Fills in the information Accordingly.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
<tr><td> <em>Sub-Task 5: </em> Add a direct link to heroku prod for this file (can be any specific item)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/product_page.php?id=1">http://the4-prod.herokuapp.com/Project/product_page.php?id=1</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 6: </em> Add to Cart </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot of the success message of adding to cart</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179566815-33092f60-6bc5-4910-b6da-737ea6ff4a34.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Logged In User Added to Cart<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot of the error message of adding to cart (i.e., when not logged in)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179566861-2c10d976-b1f1-4dac-9aba-a16d0abd95fd.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>User not Logged in<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add a screenshot of the Cart table with data in it</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179572401-fb251207-345d-4f8d-80ab-f01d7fa66159.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Cart Table<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Tell how your cart works (1 cart per user; multiple carts per user)</td></tr>
<tr><td> <em>Response:</em> <p>1 cart per user.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 5: </em> Explain the process of add to cart</td></tr>
<tr><td> <em>Response:</em> <p>Once user press quick Add or Add with desired quantity on Product Page<br>that information is sent to php add_to_cart by JS AJAX function. There the<br>information is added to the table with the user ID saved on to<br>table to connect them to their cart.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 6: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 7: </em> User will be able to see their Cart </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshot of the Cart View</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179572545-e676888e-9395-4717-a3c1-bddcf3796e65.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Cart Page<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179574187-a2a6cee3-e176-40f5-b5e7-ae56c320896a.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>First Product Item Page In Cart<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179574215-4a1ce204-a15e-412b-9814-941a549b34a8.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>First Product Item Page In Cart<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Explain how the cart is being shown from a code perspective along with the subtotal and total calculations</td></tr>
<tr><td> <em>Response:</em> <p>Once the cart page is entered php makes a call to DB to<br>get the cart by matching the user_id to the cart table user_id then<br>selects the data. That data is then filled into the appropriate areas to<br>show to the user.<br></p><br></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/cart_alt.php">http://the4-prod.herokuapp.com/Project/cart_alt.php</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 8: </em> User can update cart quantity </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Show a before and after screenshot of Cart Quantity update</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179577864-0bc4d0a5-f9f5-4e1d-89b2-5c2aa1fde49d.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Before Quantity 1<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179577899-4ec68695-15c0-4e89-997e-0c037124f631.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>After Quantity 2<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Show a before and after screenshot of setting Cart Quantity to 0</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179577864-0bc4d0a5-f9f5-4e1d-89b2-5c2aa1fde49d.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Before Quantity 1<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179577985-401da10e-1886-4fbd-b09a-7bd43b10ab59.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>INVALID FLASH<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Show how a negative quantity is handled</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179578279-f1723104-c423-4682-861e-69c275bde0ae.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Negative Inputs Not Allowed<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain the update process including how a value of 0 and negatives are handled</td></tr>
<tr><td> <em>Response:</em> <p>Once new quantity is submitted it overwrites the existing data of the matching<br>cart id. When 0 is submitted a check fails and the message is<br>sent back to create a flash with it warning user. Negative are not<br>allowed by form restriction.<br></p><br></td></tr>
<tr><td> <em>Sub-Task 5: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 9: </em> Cart Item Removal </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a before and after screenshot of deleting a single item from the Cart</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179579373-35115f1d-06a5-4970-8d94-2f9d4df0f2a2.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Before<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179579040-85369fd0-93f4-45dd-b8b8-939c3f2831c6.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Deleted Single Item<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a before and after screenshot of clearing the cart</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179579373-35115f1d-06a5-4970-8d94-2f9d4df0f2a2.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Before<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179579550-a9911d32-2f5d-4bab-af0c-a9bc49da22eb.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Clear Cart<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly explain how each delete process works</td></tr>
<tr><td> <em>Response:</em> <p>Once Clear Button is Pressed PHP sends a query to delete from cart<br>table where the user_id matches current user.<div>Delete One deletes where item id matches<br>and user id matches&nbsp;</div><br></p><br></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/38">https://github.com/timo1227/IT202-451-M22/pull/38</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 10: </em> Misc </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots showing which issues are done/closed (project board) Incomplete Issues should not be closed (Milestone2 issues)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/179580515-e896db70-565f-4ceb-aae0-0cd2c9e8770b.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>No Incomplete <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a link to your herok prod project's login page</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="http://the4-prod.herokuapp.com/Project/login.php">http://the4-prod.herokuapp.com/Project/login.php</a> </td></tr>
</table></td></tr>
<table><tr><td><em>Grading Link: </em><a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-451-M22/it202-milestone-2-shop-project/grade/the4" target="_blank">Grading</a></td></tr></table>
