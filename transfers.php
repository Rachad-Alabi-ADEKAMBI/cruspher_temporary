<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cruspher - Transfers</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
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

                    <div class="box" v-for='detail in apiResult.response' :key='detail.id'>
                        <div class="box__btn">
                            <p @click="displayMore(detail)" v-if="!detail.showMore">
                                +
                            </p>
                            <p @click="closeMore(detail)" v-if="detail.showMore">
                                -
                            </p>
                        </div>

                        <div class="box__content">
                            <div class="box__content__top">
                                <img :src="detail.photo" alt="">
                                <p>Name: <span>{{ detail.player.name }}</span>
                                </p>
                            </div>

                            <div class="box__content__bottom" v-if="detail.showMore">
                                <div class="tab">
                                    <table border="1" class='table' width=100>
                                        <thead class="thead">
                                            <tr>
                                                <th>Date</th>
                                                <th>Leaves</th>
                                                <th>Goes to</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            <tr v-for="transfer in detail.transfers" :key="transfer.date">
                                                <td>{{ formatDate(transfer.date) }}</td>
                                                <td>
                                                    <div class="" v-for="transfer in detail.transfers"
                                                        :key="transfer.date">
                                                        <img :src="transfer.teams.in.logo" alt="">
                                                        <p>
                                                            Club: <strong>{{ transfer.teams.in.name }}</strong> <br>
                                                            Date: <strong
                                                                class="red">{{ formatDate(transfer.date) }}</strong>
                                                            <br>
                                                            Type: <strong>{{ transfer.type || 'N/A' }}</strong>
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="" v-for="transfer in detail.transfers"
                                                        :key="transfer.date">
                                                        <img :src="transfer.teams.out.logo" alt="">
                                                        <p>
                                                            Club: <strong>{{ transfer.teams.out.name }}</strong> <br>
                                                            Date: <strong
                                                                class="green">{{ formatDate(transfer.date) }}</strong>
                                                            <br>
                                                            Type: <strong>{{ transfer.type || 'N/A' }}</strong>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                showCloseBtn: false,
                idList: [550],
                detailsList: [],
                allTransfers: [],
                searchQuery: '',
                showAll: true,
                showResults: false
            };
        },
        mounted() {
            this.getGames();
        },
        methods: {
            async getGames() {
                try {
                    const currentDate = new Date();
                    const formattedDate = currentDate.toISOString().split('T')[0];

                    const myHeaders = new Headers();
                    myHeaders.append("x-rapidapi-key", "aa2feb2e6dba6ca9a3e4e583ec2719db");
                    myHeaders.append("x-rapidapi-host",
                        "https://v3.football.api-sports.io/transfers?team=550");

                    const requestOptions = {
                        method: 'GET',
                        headers: myHeaders,
                        redirect: 'follow',
                    };

                    const response = await fetch("https://v3.football.api-sports.io/transfers?team=550",
                        requestOptions);

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();
                    console.log(result);
                    this.apiResult = result;
                } catch (error) {
                    console.error('Error:', error);
                }
            },

            displayMore(detail) {
                this.showMore = true;
                this.showMoreBtn = false;
                this.showCloseBtn = true;
                detail.showMore = true;
            },
            closeMore(detail) {
                this.showMore = false;
                this.showMoreBtn = true;
                this.showCloseBtn = false;
                detail.showMore = false;
            },
            getImgUrl(pic) {
                return pic;
            },
            formatDate(dateString) {
                if (dateString) {
                    const [year, month, day] = dateString.split('-');
                    const formattedDate = `${day}-${month}-${year}`;
                    return formattedDate;
                }

                return 'Present';
            },

            searchQueryAction() {
                this.showAll = false;
                this.showResults = true;
                console.log('Search query changed:', this.searchQuery);
            },
            closeResults() {
                this.showAll = true;
                this.showResults = false;
            }

        },
    }).mount('#app');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>