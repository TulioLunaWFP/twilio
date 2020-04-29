# twiliohackathon
#twiliohackathon

# Twilio 
Twilio Example for City Hall to Send MMS to help COVID19
This is a GitHub template for creating other Twilio sample

# How it works
This application is going to help any City Hall in order to send MMS to all the citizens that they have in one database.
1st when the City Hall register one citizen automatically send one MMS to welcome message
2nd in addition the City Hall can send one MMS to all the citizens that hey have in the database in order to send information
about COVID19, quarantine, or other importat information

# Twilio Account Settings
This application should give you a ready-made starting point for writing your own appointment reminder application. Before we begin, we need to collect all the config values we need to run the application:

| Config Value | Description  |
| ------- | --- |
| Account Sid | Your primary Twilio account identifier - find this in the Console | 
| Auth Token | Used to authenticate | 
| Phone number | A Twilio phone number | 

# How to use it
1. Create a copy using  [GitHub's repository template ](https://help.github.com/en/github/creating-cloning-and-archiving-repositories/creating-a-repository-from-a-template) functionality
2. Updates your Twilio values of your account
3. Go to LOCALHOST or IP /mms/public/customer to Add new citizen
4. Go to LOCALHOST or IP /mms/public/MMS to send to all in the database
5. Media is located in mms/public/mms
6. Script of database is on mms/database
7. Go to  /mms/app/controllers/homecontroller.php to change values
8. Go to  /mms/app/controllers/smscontroller.php to change values
9. Go to  /mms/bootstrap/cache/config.php to change values

# License
[MIT](https://opensource.org/licenses/mit-license.html)

# Disclaimer
No warranty expressed or implied. Software is as is.
	
