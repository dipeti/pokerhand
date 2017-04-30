PokerHand
=========


If you want to run the application in [**Docker**][1] you need the following commands:
1. [**Build the app**][2] 
  docker build -t peterdinya/poker .
2. [**Run the app**][3] 
  docker run -p 8000:80 --name poker peterdinya/poker
3. Open [**localhost:8000**][4] in your browser. 

Enjoy!

[1]:  https://www.docker.com/
[2]:  https://docs.docker.com/get-started/part2/#build-the-app
[3]:  https://docs.docker.com/get-started/part2/#run-the-app
[4]:  http://localhost:8000/