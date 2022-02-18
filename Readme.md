# Assigment Description

The attachment named __example.php__ is a simple PHP script. It's job is to serve one json-encoded string in response to
 an http request. The script is also using __turbines.csv__ for fetching turbines data. 

Your task is to refactor this script. Remove all mistakes and bad practices, create some structure of folders and files that will contain classes, design architecture as if this simple script was a small part of a much bigger project. In other words: pimp up this script! 

This is more about the architecture of your code and less about the function itself. We will assess you on the structure, the hierarchy of objects and the overall design. 

Take into consideration how clean your code is and how easy it is to read and understand it. Avoid tight coupling between any layer you introduce to this code and remember that this code should be easy for further extension by somebody else. 

Also, using the created code, add a full CRUD feature to it. You may change e data storage system if you want. In the end, the system should allow to add a new entry and/or remove update existing ones. There is no need to create any form of UI.

You have the total freedom to decide on how to achieve this. There are, however, some rules as described below.

# General Requirements

* You __may not__ use any external library or framework __except from the ones used to Unit Test the solution__.
* After refactoring, this code __must__ do the same thing.
* You __have to__ use OOP.
* You __should__ introduce some framework-like feature (routing, dispatching, autoloading).
* You __have to__ use at least PHP 7
* You __can__ use psr-0 autoloading system.
* You __can__ put comments where you describe why you do certain things or just explaining some more high level decision.
* You __can__ change storage system for turbine data.
* __All above rules are very important!__
  * Have to, may not - this is mandatory.
  * Could, should - this is strongly recommended. 
   * Can - it's up to you.

### Bonus

Cover the code with Unit Tests or even better, build it using a TDD approach!

# Final Notes

* Remember that this is Web-based application, http statuses are important. 
* Code should have some basic exception control and data validation.
* You can use REST architecture - this will be a plus.
* The design of this code is more important than it’s function. Focus on good, clean architecture!
* Follow programming principles! If you don’t know what that is, search SOLID in object oriented design.
* This exercise shouldn’t take more than 5 hours. We don’t expect a finished product.


# Support

Should you have any questions or concerns, please do get in touch.
