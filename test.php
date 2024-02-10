<div class="box" v-for='detail in apiResult.response' :key='detail.id'>
    <div class="box__btn">
        <p @click='displayMore()' v-if='showMoreBtn'>
            +
        </p>

        <p @click='closeMore()' v-if='showCloseBtn'>
            -
        </p>
    </div>


    <div class="box__content">
        <div class="box__content__top">
            <p>{{ detail.firstname }} {{ detail.name }} <br>
                Nationality: {{ detail.nationality }} <br>
                Age: {{ detail.age }}
            </p>

            <img :src="detail.photo" alt="">
        </div>

        <div class="box__content__bottom" v-if="showMore">
            <div class="flag">
                <h2>Current club</h2>
                <img :src="detail.team.logo" alt="">
            </div>

            <div class="clubs">
                <!-- Display flags of past clubs -->
                <h2>
                    Old clubs
                </h2>
                <div class="list">
                    <div v-for="club in detail.career" :key="club.team.id" class="club">
                        <img :src="club.team.logo" alt="">
                        <p>
                            Start date: {{ formatDate(club.start) }} <br>
                            End date: {{ formatDate(club.end) || 'Present' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>


/* var currentDate = new Date();
var formattedDate = currentDate.toISOString().split('T')[0]; // Formats the date as 'yyyy-mm-dd'

var myHeaders = new Headers();
myHeaders.append("x-rapidapi-key", "71d95ba09f4094fa6f5f291f089cb27b");
myHeaders.append("x-rapidapi-host", "https://v3.football.api-sports.io/coachs?id=50");

var requestOptions = {
method: 'GET',
headers: myHeaders,
redirect: 'follow',
};

fetch("https://v3.football.api-sports.io/coachs?id=50", requestOptions)
.then(response => response.json())
.then(result => {
console.log(result);
this.apiResult = result;
})
.catch(error => {
console.log('error', error);
});
*/