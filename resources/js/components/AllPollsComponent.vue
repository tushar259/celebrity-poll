<template>
    <div v-if="pollFound == false" class="parent-background">
        Page not found
    </div>
    <div v-else-if="pollFound == null" class="loading-spinner-view parent-background">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-else-if="pollFound == true" class="parent-background">
        
        <div class="row poll-page-background">
            <!-- <div class="card my-3" v-for="(poll, index) in allPolls" :key="index">
                <div class="card-body">
                <span class="card-title">{{poll.poll_title}} (Closing at {{poll.ending_date}})</span>
                    <div v-for="(tag, indexT) in poll.poll_tags" :key="indexT" style="display: inline-block;">
                        {{tag.polls}} ({{tag.votes}} votes)
                        <div v-if="indexT !== poll.poll_tags.length - 1" style="display: inline-block;">, </div>
                    </div>
                </div>
            </div> -->
            <div class="styling-link-for-home font-selected">
                <router-link to="" class="navigator-link">Home</router-link>
            </div>
            
            <div class="col-md-6">
                <div class="poll-heads-in-all-poll">
                    <!-- <hr> -->
                    <!-- <div class="px-10-gap"></div> -->
                    <span>New polls</span>
                    <!-- <div class="px-10-gap"></div> -->
                    <!-- <hr> -->
                </div>
                <div v-if="allRecentPollsFound == true">
                    <div v-for="(poll, index) in allRecentUploadedPolls" :key="index">
                        <!-- <router-link class="card my-3 custom-card-border" @click="endingPollClicked($event, poll.table_name_starts_with)" :to="'/poll/'+poll.table_name_starts_with">  -->
                        <router-link class="card my-3 custom-card-border" :to="'/poll/'+poll.table_name_starts_with"> 
                            <div class="which-industry">{{poll.which_industry}}</div>
                            <div class="card-body d-flex">
                                <div>
                                    <img :src="'/../'+poll.thumbnail_image" class="thumbnail-images-in-list-of-polls">
                                </div>
                                <div class="thumbnail-texts-in-list-of-polls">
                                    <h4 class="card-title custom-card-title">
                                    {{poll.poll_title}} (Closing at <span class="custom-card-ending-date">{{poll.ending_date}}</span>)
                                    </h4>
                                    
                                    <div v-for="(tag, indexT) in poll.poll_tags" :key="indexT" class="card-name-n-votes">
                                        <div v-if="indexT <= 1">
                                            <span v-if="indexT !== poll.poll_tags.length - 1">
                                                <b>{{tag.polls}}</b>({{tag.votes}} votes),&nbsp;
                                            </span>
                                            <span v-else>
                                                <b>{{tag.polls}}</b>({{tag.votes}} votes)
                                            </span>
                                        </div>
                                    </div>
                                    ..See more
                                </div>
                            </div>
                        </router-link>
                        <div v-if="index%3==0">
                            ad
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-6" >
                <div class="poll-heads-in-all-poll recent-results-head">
                    <!-- <hr> -->
                    <!-- <div class="px-10-gap"></div> -->
                    <span>Recent results</span>
                    <!-- <div class="px-10-gap"></div> -->
                    <!-- <hr> -->
                </div>
                <div v-if="resultPollsFound == true">
                    <div v-for="(poll, index) in resultAllPolls" :key="index">
                        <!-- <router-link class="card my-3 custom-card-border" @click="resultPollsClicked($event, poll.table_name_starts_with)" :to="'/poll-winner/'+poll.table_name_starts_with"> -->
                        <router-link class="card my-3 custom-card-border" :to="'/poll-winner/'+poll.table_name_starts_with">
                            <div class="which-industry">{{poll.which_industry}}</div>
                            <div class="card-body d-flex">
                                <div>
                                    <img :src="'/../'+poll.thumbnail_image" class="thumbnail-images-in-list-of-polls">
                                </div>
                                <div class="thumbnail-texts-in-list-of-polls">
                                    <h4 class="card-title custom-card-title">
                                    {{poll.poll_title}} <span class="custom-card-winning-date">(Published {{poll.updated_at}})</span>
                                    </h4>
                                    
                                    ..See more
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <!-- <div class="poll-heads-in-all-poll ending-poll" @click="showEndingPolls = !showEndingPolls"> -->
                <div class="poll-heads-in-all-poll ending-poll">
                    <!-- <hr> -->
                    <!-- <div class="px-10-gap"></div> -->
                    <span>Polls ending</span>
                    <!-- <div class="px-10-gap"></div> -->
                    <!-- <hr> -->
                </div>
                <!-- <div v-if="allPollFound == true" :class="{'d-none': showEndingPolls}"> -->
                <div v-if="allPollFound == true">
                    <div v-for="(poll, index) in allPolls" :key="index">
                        <!-- <router-link class="card my-3 custom-card-border" @click="endingPollClicked($event, poll.table_name_starts_with)" :to="'/poll/'+poll.table_name_starts_with"> -->
                        <router-link class="card my-3 custom-card-border" :to="'/poll/'+poll.table_name_starts_with">
                            <div class="which-industry">{{poll.which_industry}}</div>
                            <div class="card-body d-flex">
                                <div>
                                    <img :src="'/../'+poll.thumbnail_image" class="thumbnail-images-in-list-of-polls">
                                </div>
                                <div class="thumbnail-texts-in-list-of-polls">
                                    <h4 class="card-title custom-card-title">
                                    {{poll.poll_title}} (Closing at <span class="custom-card-ending-date">{{poll.ending_date}}</span>)
                                    </h4>
                                    
                                    <div v-for="(tag, indexT) in poll.poll_tags" :key="indexT" class="card-name-n-votes">
                                        <div v-if="indexT <= 1">
                                            <span v-if="indexT !== poll.poll_tags.length - 1">
                                                <b>{{tag.polls}}</b>({{tag.votes}} votes),&nbsp;
                                            </span>
                                            <span v-else>
                                                <b>{{tag.polls}}</b>({{tag.votes}} votes)
                                            </span>
                                        </div>
                                    </div>
                                    ..See more
                                </div>
                            </div>
                        </router-link>
                        <div v-if="index%3==0">
                            ad
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return{
                allPolls: [],
                pollFound: null,
                allPollFound: null,
                resultAllPolls: [],
                resultPollsFound: null,
                token: localStorage.getItem('token'),
                userEmail: '',
                allRecentUploadedPolls: [],
                allRecentPollsFound: null,
                // showRecentPolls: false,
                // showResultPolls: false,
                // showEndingPolls: false,
            }
        },

        created() {
            this.getAllRecentPolls();
            this.getAllPollsEnding();
            this.getlistOfResultPolls();
        },

        methods: {
            getAllRecentPolls(){
                axios.get('/api/get-all-recent-uploaded-poll')
                .then(response => {
                    
                    if(response.data.success == true){
                        this.allRecentPollsFound = true;
                        
                        response.data.all_polls.forEach(item => {
                            // item.all_tags = response.data.all_tags;
                            item.ending_date = moment(item.ending_date).format('D MMM YYYY');
                            this.allRecentUploadedPolls.push(item);
                        });
                        // console.log("why");
                        // console.log(this.allRecentUploadedPolls);
                        // console.log("why");
                        
                    }
                    else if(response.data.success == false && response.data.message == "No polls uploaded yet"){
                        this.allRecentPollsFound = false;
                    }
                    else{
                        this.allRecentPollsFound = false;
                    }
                    this.pollFound = true;
                })
                .catch(error => {
                    console.log(error);
                    this.pollFound = true;
                    this.allRecentPollsFound = false;
                });
            },

            getAllPollsEnding(){
                axios.get('/api/get-all-poll')
                .then(response => {
                    if(response.data.success == true){
                        this.allPollFound = true;
                        
                        response.data.all_polls.forEach(item => {
                            // item.all_tags = response.data.all_tags;
                            item.ending_date = moment(item.ending_date).format('D MMM YYYY');
                            this.allPolls.push(item);
                        });
                        console.log(response);
                    }
                    else if(response.data.success == false && response.data.message == "No polls uploaded yet"){
                        this.allPollFound = false;
                    }
                    else{
                        this.allPollFound = false;
                    }
                    this.pollFound = true;
                })
                .catch(error => {
                    console.log(error);
                    this.pollFound = true;
                    this.allPollFound = false;
                });
            },

            getlistOfResultPolls(){
                axios.get('/api/get-result-list-poll')
                .then(response => {
                    if(response.data.success == true){
                        this.resultPollsFound = true;
                            
                        response.data.all_poll_result.forEach(item => {
                            item.updated_at = this.beautifyTime(item.updated_at);
                            this.resultAllPolls.push(item);
                        });
                    }
                    else if(response.data.success == false && response.data.message == "No poll found"){
                        this.resultPollsFound = false;
                    }
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
            },

            endingPollClicked(event, table_name_starts_with){
                if (event.ctrlKey){
                    window.open('/poll/'+table_name_starts_with, '_blank');
                }
                else{
                    window.location.href = '/poll/'+table_name_starts_with;
                }
                // this.$router.push(`/poll/${table_name_starts_with}`);
            },

            resultPollsClicked(event, table_name_starts_with){
                if (event.ctrlKey){
                    window.open('/poll-winner/'+table_name_starts_with, '_blank');
                }
                else{
                    window.location.href = '/poll-winner/'+table_name_starts_with;
                }
                // this.$router.push(`/poll/${table_name_starts_with}`);
            },

            beautifyTime(timestamp) {
                timestamp = Date.parse(timestamp) / 1000;
                const now = Date.now() / 1000;
                const diff = Math.floor(now - timestamp);
                if (diff < 60) {
                    return 'now';
                } else if (diff < 3600) {
                    const minutes = Math.floor(diff / 60);
                    return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else if (diff < 86400) {
                    const hours = Math.floor(diff / 3600);
                    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    const days = Math.floor(diff / 86400);
                    return `${days} day${days > 1 ? 's' : ''} ago`;
                }
            },

            checkIfUserLoggedin(){
                const formData = new FormData();
                formData.append("token", this.token);
                if(localStorage.getItem('token')){
                    axios.post('/api/auth/check-if-user-logged-in', {
                        // other data you want to send
                    }, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                    .then(response =>{
                        console.log(response.data);
                        if(response.data.success == true && response.data.message == "User logged in"){
                            this.userEmail = response.data.userInfoFromTk.email;
                            // this.userId = response.data.userInfoFromTk.id;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
                else{
                    //no token means no user logged in
                    console.log("no token in storage");
                }
            }
        }
    }
</script>
