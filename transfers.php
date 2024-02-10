<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cruspher - Transfers</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>

<body>
    <div class="app" id="app">
        <header class="header">
            <div class="header__logo">
                <img src="logo.png" alt="">
            </div>
            <ul class="header__menu">
                <li><a href="index.php">Coachs |</a></li>
                <li><a href="transfers.php">Transfers |</a></li>
                <li><a href="trophies.php">Trophies</a></li>
                <li><a href="injuries.php">Injuries |</a></li>
            </ul>
        </header>

        <main class="main">
            <h1>
                Transfers
            </h1>

            <div class="main__content">

                <div class="search">
                    <h2>
                        Search
                    </h2>
                    <div class="search__box">
                        <input type="search" class='input' placeholder='type a name'>
                        <div class="close">X</div>
                    </div>
                </div>
                <div class="boxes">
                    <h2>
                        Team name : <span>Shakhtar Donetsk</span>
                    </h2>
                    <div class="box" v-for="detail in apiResult.response" :key="detail.player.id">
                        <div class="box__btn">
                            <p @click="displayMore(detail)" v-if="showMoreBtn">
                                +
                            </p>
                            <p @click="closeMore()" v-if="showCloseBtn">
                                -
                            </p>
                        </div>
                        <div class="box__content">
                            <div class="box__content__top">
                                <p>{{ detail.player.name }}</p>
                                <img :src="detail.player.photo" alt="">
                            </div>
                            <div class="box__content__bottom" v-if="showMore">
                                <div class="flag">
                                    <h3>In</h3>
                                    <div v-for="transfer in detail.transfers" :key="transfer.date" class="club">
                                        <img :src="transfer.teams.in.logo" alt="">
                                        <p>
                                            {{ transfer.teams.in.name }} <br>
                                            Date: {{ formatDate(transfer.date) }} <br>
                                            Type: {{ transfer.type || 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="arrow">
                                    <img src="https://www.pngkit.com/png/full/497-4978152_arrow-right-black-background.png"
                                        alt="">
                                </div>
                                <div class="flag">
                                    <h3>Out</h3>
                                    <div v-for="transfer in detail.transfers" :key="transfer.date" class="club">
                                        <img :src="transfer.teams.out.logo" alt="">
                                        <p>
                                            {{ transfer.teams.out.name }} <br>
                                            Date: {{ formatDate(transfer.date) }} <br>
                                            Type: {{ transfer.type || 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
    const {
        createApp
    } = Vue;

    createApp({
        data() {
            return {
                apiResult: {
                    get: '',
                    parameters: [],
                    errors: [],
                    results: null,
                    response: '',
                },
                showMore: false,
                showMoreBtn: true,
                showCloseBtn: false
            };
        },
        mounted() {
            this.getGames();
        },
        methods: {
            getGames() {
                var currentDate = new Date();
                var formattedDate = currentDate.toISOString().split('T')[0]; // Formats the date as 'yyyy-mm-dd'

                var myHeaders = new Headers();
                myHeaders.append("x-rapidapi-key", "71d95ba09f4094fa6f5f291f089cb27b");
                myHeaders.append("x-rapidapi-host", "https://v3.football.api-sports.io/transfers?team=550");

                var requestOptions = {
                    method: 'GET',
                    headers: myHeaders,
                    redirect: 'follow',
                };

                fetch("https://v3.football.api-sports.io/transfers?team=550", requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        console.log(result);
                        this.apiResult = result;
                    })
                    .catch(error => {
                        console.log('error', error);
                    });
            },
            displayMore() {
                this.showMore = true;
                this.showMoreBtn = false;
                this.showCloseBtn = true;
            },
            closeMore() {
                this.showMore = false;
                this.showMoreBtn = true;
                this.showCloseBtn = false;
            },
            getImgUrl(pic) {
                return pic;
            },
            formatDate(date) {
                // Check if the date is not null or undefined
                if (date) {
                    // Replace this logic with your desired date formatting
                    // For example, using a library like date-fns or moment.js
                    // Here's a simple example:
                    const formattedDate = new Date(date).toLocaleDateString();
                    return formattedDate;
                }

                // If the date is null or undefined, return 'Present'
                return 'Present';
            }

        },
    }).mount('#app');
    </script>
</body>

</html>