<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cruspher - Coachs</title>
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
                Coachs
            </h1>

            <div class="main__content">

                <div class="search">
                    <h2>
                        Search
                    </h2>

                    <div class="search__box">
                        <input type="search" class='input' placeholder='type a name' v-model="searchQuery">
                        <div class="close" @click="closeResults">X</div>
                    </div>


                </div>
                <div class="boxes" v-if="showAll">
                    <div class="box" v-for='detail in detailsList' :key='detail.id'>
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
                                <img :src="detail.photo" alt=""> <br>
                                <p>Name: <span>{{ detail.firstname }} {{ detail.name }}</span> <br>
                                    Nationality: <span>{{ detail.nationality }}</span> <br>
                                    Age: <span>{{ detail.age }}</span>
                                </p>


                            </div>

                            <div class="box__content__bottom" v-if="detail.showMore">
                                <div class="flag">
                                    <h2>Current club</h2>
                                    <img :src="detail.club" alt="">
                                </div>

                                <div class="clubs">
                                    <h2>
                                        Old clubs
                                    </h2>
                                    <div class="list">
                                        <div v-for="club in detail.career" :key="club.team.id" class="club">
                                            <img :src="club.team.logo" alt="">
                                            <p>
                                                <span class="green">{{ formatDate(club.start) }}</span> <br>
                                                <strong class="red">{{ formatDate(club.end) || 'Present' }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="boxes" v-if="showResults">
                    <h2>Search results</h2> <br>

                    <div class="box" v-if="filteredDetailsList.length > 0" v-for="detail in filteredDetailsList"
                        :key="detail.id" style="color: white; font-weight: bold">
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


                                <img :src="detail.photo" alt=""> <br>
                                <p>{{ detail.firstname }} {{ detail.name }} <br>
                                    Nationality: {{ detail.nationality }} <br>
                                    Age: {{ detail.age }}
                                </p>
                            </div>

                            <div class="box__content__bottom" v-if="detail.showMore">
                                <div class="flag">
                                    <h2>Current club</h2>
                                    <img :src="detail.club" alt="">
                                </div>

                                <div class="clubs">
                                    <h2>
                                        Old clubs
                                    </h2>
                                    <div class="list">
                                        <div v-for="club in detail.career" :key="club.team.id" class="club">
                                            <img :src="club.team.logo" alt="">
                                            <p>
                                                <span class="green">{{ formatDate(club.start) }}</span> <br>
                                                <strong class="red">{{ formatDate(club.end) || 'Present' }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div> <br>


                    <strong v-if="filteredDetailsList.length == 0" style="color: white; text-center: align">
                        There is no result for this query
                    </strong>
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
                allCoachs: {},
                idList: [50, 435, ],
                detailsList: [],
                searchQuery: '',
                showAll: true,
                showResults: false
            };
        },

        mounted() {
            this.getGames();
        },

        computed: {
            filteredDetailsList() {
                return this.detailsList.filter(detail =>
                    detail.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            },
        },

        watch: {
            searchQuery() {
                this.searchQueryAction();
            },
        },

        methods: {
            async getGames() {
                let list = this.idList;
                let details = [];

                for (let i = 0; i < list.length; i++) {
                    try {
                        const response = await fetch(
                            `https://v3.football.api-sports.io/coachs?id=${encodeURIComponent(list[i])}`, {
                                method: 'GET',
                                headers: {
                                    "x-rapidapi-key": "aa2feb2e6dba6ca9a3e4e583ec2719db",
                                    "x-rapidapi-host": "v3.football.api-sports.io"
                                },
                                redirect: 'follow',
                            });

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        const result = await response.json();
                        console.log(result);
                        let detail = {
                            id: list[i],
                            name: result.response[0].firstname + ' ' + result.response[0].lastname,
                            age: result.response[0].age,
                            nationality: result.response[0].nationality,
                            photo: result.response[0].photo,
                            team: result.response[0].team,
                            career: result.response[0].career,
                            club: result.response[0].team.logo,
                            showMore: false
                        };

                        details.push(detail);
                    } catch (error) {
                        console.error('Error fetching data:', error);
                    }
                }

                console.log(details);
                this.detailsList = details;
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
            formatDate(date) {
                if (date) {
                    const formattedDate = new Date(date).toLocaleDateString();
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
</body>

</html>