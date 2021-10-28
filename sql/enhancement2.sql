/* SQL queries for enhancement 2 */

/*Add new client */
INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment) VALUES 
	("Tony", "Stark", "tony@starkent.com", "Iam1ronM@n", "I am the real Ironman")

/*update client */
    UPDATE `clients` SET clientLevel = "3" WHERE clientFirstname = "Tony"

/*change Hummer description*/
    UPDATE inventory SET invDescription = replace(invDescription, "small interiors", "spacious interiors") WHERE invId = 12

/*output SUV classificaiton name */
    SELECT carclassification.classificationName, inventory.invMake, inventory.invModel  FROM carclassification INNER JOIN inventory ON inventory.classificationId=carclassification.classificationId WHERE carclassification.classificationId = 1;

/* delete jeep wrangler   */
    DELETE FROM inventory WHERE invMake = "Jeep"

/* add /phpmotors to images */
    UPDATE inventory SET invImage=CONCAT("/phpmotors", invImage)
    UPDATE inventory SET invThumbnail=CONCAT("/phpmotors", invThumbnail)