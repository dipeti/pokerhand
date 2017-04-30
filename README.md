PokerHand
=========

Description
------
The application is able to find the highest combination of 5 randomly generated French playing cards. You can use multiple decks which the five cards are chosen from. To do so, enter an integer parameter after the base url. Eg.: ```http://localhost:8000/app.php/5```

Each card instance is created using a string parameter passed through to the static ```Card::getInstance(string $text)``` method. The Singleton pattern is ensured by making the constructor private. However, the proper formatting of the parameter needs to be highlighted. Be wary that the first character represents the suit (__C__lubs, __D__iamonds, __S__pades, __H__earts) of the card. The following characters need to be one of the possible ranks defined by the rules of poker (... __8__, __9__, __10__, __K__, __A__ etc.). Sticking with the aforementioned assertions you will get a Hearts of 2 by using ```Card::getInstance("H2"); ```

__Tests__ were also created for the app to avoid erroneous outcomes. These are run while building the application. 

The __result__ you will see includes the 5 randomly generated cards and the highest hand possible. 

Using with Docker
------
If you want to run the application in [**Docker**][1] you need the following commands:
1. [**Build the app**][2]
```
docker build -t peterdinya/poker .
```
2. [**Run the app**][3]
```
docker run -p 8000:80 --name poker peterdinya/poker
```
3. Open [**localhost:8000**][4] in your browser. 

Enjoy!

[1]:  https://www.docker.com/
[2]:  https://docs.docker.com/get-started/part2/#build-the-app
[3]:  https://docs.docker.com/get-started/part2/#run-the-app
[4]:  http://localhost:8000/