<table><tr><td> <em>Assignment: </em> IT202 Milestone1 Deliverable</td></tr>
<tr><td> <em>Student: </em> Timothy Estrada(the4)</td></tr>
<tr><td> <em>Generated: </em> 7/6/2022 2:28:59 AM</td></tr>
<tr><td> <em>Grading Link: </em> <a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-451-M22/it202-milestone1-deliverable/grade/the4" target="_blank">Grading</a></td></tr></table>
<table><tr><td> <em>Instructions: </em> <ol><li>Checkout Milestone1 branch</li><li>Create a milestone1.md file in your Project folder</li><li>Git add/commit/push this empty file to Milestone1 (you'll need the link later)</li><li>Fill in the deliverable items<ol><li>For each feature, add a direct link (or links) to the expected file the implements the feature from Heroku Prod (I.e,&nbsp;<a href="https://mt85-prod.herokuapp.com/Project/register.php">https://mt85-prod.herokuapp.com/Project/register.php</a>)</li></ol></li><li>Ensure your images display correctly in the sample markdown at the bottom</li><li>Save the submission items</li><li>Copy/paste the markdown from the "Copy markdown to clipboard link" or via the download button</li><li>Paste the code into the milestone1.md file or overwrite the file</li><li>Git add/commit/push the md file to Milestone1</li><li>Double check the images load when viewing the markdown file (points will be lost for invalid/non-loading images)</li><li>Make a pull request from Milestone1 to dev and merge it (resolve any conflicts)<ol><li>Make sure everything looks ok on heroku dev</li></ol></li><li>Make a pull request from dev to prod (resolve any conflicts)<ol><li>Make sure everything looks ok on heroku prod</li></ol></li><li>Submit the direct link from github prod branch to the milestone1.md file (no other links will be accepted and will result in 0)</li></ol></td></tr></table>
<table><tr><td> <em>Deliverable 1: </em> Feature: User will be able to register a new account </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add one or more screenshots of the application showing the form and validation errors per the feature requirements</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177474196-6f762e47-03ab-4e45-821a-7de83aba09bb.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Base Register Page<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177474146-6d810cd4-d07b-4888-91f2-6a2c72871344.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>After Client Side Validation <br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177474422-fc87a75e-219a-4f55-a948-263167dad5c5.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Email not Available<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177474594-076f927b-ee0b-4a50-a055-c66e0cbb73d8.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Username not Available<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177474594-076f927b-ee0b-4a50-a055-c66e0cbb73d8.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>New User Registration<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot of the Users table with data in it</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177474923-188a5eec-ec6e-442b-a648-ccebb0d067a2.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>New User in Users Table in DB<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works</td></tr>
<tr><td> <em>Response:</em> <p>Once all the fields have been filled and Register Button has been clicked<br>the function to validate will begin. Using REGEX tests the Email and Username<br>so that they fit the constraints that have been set and if they<br>pass a boolean Variable will remain true. Next, the two password values will<br>be checked to see if they match the function will return Valid which<br>is true. However, if any of these statements fail Valid will be set<br>to false and return false not allowing the form to be submitted and<br>an error message will appear Underneath the input that needs to be fixed.<br>Once the form is able to be submitted PHP is used to make<br>sure the email nor the username already exists by checking the DB and<br>also running the same test to validate the Username Email and password the<br>Validation function in Javascript did. PHP takes the extra step to hash the<br>new password before sending all the information to be stored into the DB<br>under the Users Table.<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 2: </em> Feature: User will be able to login to their account </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add one or more screenshots of the application showing the form and validation errors per the feature requirements</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177476040-ec9918ba-9f8c-4365-bfd8-7d861c61291e.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Invalid PW at Login<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177476194-fd5d93c2-cd55-4e5d-85a9-ede0f81875f8.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Non-Existing User<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot of successful login</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177476279-40f51ce0-0b34-48c5-9aa9-d37758cf68a5.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Successful Login<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works</td></tr>
<tr><td> <em>Response:</em> <p>Once all fields are filled and login is Clicked JS Validation function checks<br>to see if either a Username or Email is being used to log<br>in by checking REGEX for both and if they pass the Valid variable<br>remains True. Next checks to make sure PW is long Enough if not<br>Valid is set to false. Once the test is passed the form is<br>able to be submitted and PHP Checks what is being used to login<br>with a helper function that uses regex as well. Once it is known<br>which it checks the User Table in the DB if that data exists<br>and if so it Checks if the encrypted passwords match and if so<br>the Session begins with User and redirects to the Home page.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 3: </em> Feat: Users will be able to logout </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the successful logout message</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177477175-4f766432-4297-4ab3-bd45-fcbf2c120bcd.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Logout Success <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot showing the logged out user can't access a login-protected page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177477280-50583703-c93c-4ac0-bb45-36e574e5c37e.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Attempt to Access Login Protected Page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works</td></tr>
<tr><td> <em>Response:</em> <p>Once the Logout page is visited the Session Ends terminating the User login<br>access and begins a New One so that they are able to log<br>in once again and redirected to the Login Page&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 4: </em> Feature: Basic Security Rules Implemented / Basic Roles Implemented </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the logged out user can't access a login-protected page (may be the same as similar request)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177477806-7f58a49a-bd52-4fb8-8bfe-9384e91f5cc6.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Attempt to Visit Admin Page while logged Out<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot showing a user without an appropriate role can't access the role-protected page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177477948-ef1a94e0-a9df-44cb-afb4-770c701e237d.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>No Role Attempt to Access Admin Page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add a screenshot of the Roles table with valid data</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177478064-ec016a7a-9cba-425d-9c21-623251f8f6fb.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Roles Table<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a screenshot of the UserRoles table with valid data</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177478233-31dc9288-6a27-4a58-8d91-5ab3414e3ff9.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>tim1227 is admin <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 5: </em> Add the related pull request(s) for these features</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/pull/21">https://github.com/timo1227/IT202-451-M22/pull/21</a> </td></tr>
<tr><td> <em>Sub-Task 6: </em> Explain briefly how the process/code works for login-protected pages</td></tr>
<tr><td> <em>Response:</em> <p>A helper function checks if there is a Session active with $user saved<br>and if not the loading of those pages will terminate and redirect to<br>the Login page with the message why.<br></p><br></td></tr>
<tr><td> <em>Sub-Task 7: </em> Explain briefly how the process/code works for role-protected pages</td></tr>
<tr><td> <em>Response:</em> <p>Once Login Occurs the Session collects the Role of the person logging in<br>and that User has access to those pages that will appear if not<br>the helper function will redirect them to Home with the message on why<br>the redirect occurred.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 5: </em> Feature: Site should have basic styles/theme applied; everything should be styled </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots to show examples of your site's styles/theme</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177479070-b1c50ac8-99b9-43f1-b089-edeaf7e5fec1.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Simple Navigation With Links Clear And Spaced Out<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177479131-8102515b-4ba1-472f-a399-f1a19229fbc8.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Table and Buttons Customized to always be Blue<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177479229-845374ab-338d-4e90-96e7-c8498bebf961.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Forms Styled to be User Friendly and Simple<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177479292-04a3774d-f30d-4e9c-b3bf-f9686fb226ef.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Table Information Centered for Readability <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly explain your CSS at a high level</td></tr>
<tr><td> <em>Response:</em> <p>Added A Styles Folder where I added two CSS files one for body<br>and one for Nav. Made Nav bar flex so that they could be<br>in one line and shrink and grow as needed. Rounded the Border on<br>everything to give the modern look and used white and blue as they<br>contrast each other nicely. For forms, the submit buttons will remain greyed out<br>until all required fields are filled then will change blue. Imported a custom<br>font that would be easy to read and is Appealing to the eye.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 6: </em> Feature: Any output messages/errors should be "user friendly" </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots of some examples of errors/messages</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177480327-87de085f-e2fe-4669-b09f-6ca8a8542361.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Username Taken<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a related pull request</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 3: </em> Briefly explain how you made messages user friendly</td></tr>
<tr><td> <em>Response:</em> <p>When the DB checks if that Username exists it throws an exception error<br>with a code and with that code we change the message to Something<br>that anyone can understand clearly.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 7: </em> Feature: Users will be able to see their profile </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots of the User Profile page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177480647-4724e027-5d50-4699-8bd8-caaba6e51009.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Profile Page with Pre-filed Values <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 3: </em> Explain briefly how the process/code works (view only)</td></tr>
<tr><td> <em>Response:</em> <p>The Session has the Email and Username saved in its cookies so we<br>use that to extract that information and place those Values into the input<br>boxes.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 8: </em> Feature: User will be able to edit their profile </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/f2c037/000000?text=Partial"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots of the User Profile page validation messages and success messages</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177481308-71dc31f9-e0b1-4734-8a07-9428a128809a.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Update Username and Email with Password Errors<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177481927-7e4938b2-2bda-4de7-b869-72156f2f0c86.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Username Error<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177482757-0ba93311-008a-4e9d-a724-3202bcfaf1d4.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Password Update<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177482553-84cd2b57-9a6b-454d-af18-27c8b32e407f.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Email Error<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add before and after screenshots of the Users table when a user edits their profile</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177481579-4a32de4d-84bb-4566-b4bf-16d2bb795ac6.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Before<br></p>
</td></tr>
<tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177481489-cbf80805-da66-44a1-9611-8d44aa3e274f.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>After<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the related pull request(s) for this feature</td></tr>
<tr><td>Not provided</td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain briefly how the process/code works (edit only)</td></tr>
<tr><td> <em>Response:</em> <p>Once the same JS Validation Function has returned True PHP validated the information<br>for Username And Email the same way it did a Registration by checking<br>if they are Unique on the Users table in DB. After that passes<br>it is able to be changed with no issues.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 9: </em> Issues and Project Board </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="http://via.placeholder.com/400x120/009955/fff?text=Complete"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots showing which issues are done/closed (project board) Incomplete Issues should not be closed</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://user-images.githubusercontent.com/43392928/177483383-746393bd-39f2-48ab-b1de-f99f632e3cd9.png"/></td></tr>
<tr><td> <em>Caption:</em> <p>Project Board With all Issues Closed<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Include a direct link to your Project Board</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/timo1227/IT202-451-M22/projects/1">https://github.com/timo1227/IT202-451-M22/projects/1</a> </td></tr>
<tr><td> <em>Sub-Task 3: </em> Prod Application Link to Login Page</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://the4-prod.herokuapp.com/Project">https://the4-prod.herokuapp.com/Project</a> </td></tr>
</table></td></tr>
<table><tr><td><em>Grading Link: </em><a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-451-M22/it202-milestone1-deliverable/grade/the4" target="_blank">Grading</a></td></tr></table>
