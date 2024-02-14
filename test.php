div class="flag">
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
    <img src="https://www.pngkit.com/png/full/497-4978152_arrow-right-black-background.png" alt="">
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