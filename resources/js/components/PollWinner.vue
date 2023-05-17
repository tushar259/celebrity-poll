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
        <div v-if="thumbnail != ''" class="custom-thumbnail">
            <div class="image-card">
                <div class="image-card-body">
                    <img :src="'/../'+thumbnail">
                    <br>
                    <p class="texts-under-thumbnail">image courtesy</p>
                    <h1 class="poll-title texts-under-thumbnail">{{pollTitle}}?</h1>
                    <div class="d-flex align-items-center texts-under-thumbnail">
                        <div class="poll-date">Voting started {{startingDate}}</div>
                        <div class="distance-between-two"></div>
                        <div class="poll-date">Winner published {{publishedDate}}</div>
                    </div>
                </div>
                <div class="px-10-gap"></div>
            </div>
        </div>
        <div class="px-10-gap"></div>
        <div class="styling-link font-selected">
            <router-link to="/" class="navigator-link">Home</router-link><i class='fas fa-angle-right'></i>
            <router-link to="" class="navigator-link">{{whichIndustry}}</router-link><i class='fas fa-angle-right'></i>
            <router-link :to="'/poll/'+pollId" class="navigator-link">{{pollId}}</router-link>
        </div>
        <div class="px-10-gap"></div>
        <!-- <div class="custom-details-n-poll-card-area">
            <div class="custom-details-n-poll-card">
                <div class="custom-details-n-poll-card-body">
                    <div v-html="beforePollDescription" class="poll-details"></div>
                    <div class="card my-3 custom-card poll-details">
                        <div class="card-body custom-card-body">
                            <h5 class="card-title">{{ pollTitle }}</h5>
                            <div class="px-20-gap"></div>
                            <div  v-for="(poll, index) in pollsVoted" :key="index" class="polls-in-page">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadio1" :value="poll.id">
                                    
                                    <div class="total-votes">
                                        <div class="votes-received-here" :style="{'width': poll.percent + '%'}"></div>
                                        <label class="form-check-label d-flex justify-content-between align-items-center" for="exampleRadio1">
                                            {{poll.polls}}
                                            <div></div>
                                            ~{{poll.percent}}%({{poll.votes}} votes)
                                            
                                        </label>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="px-20-gap"></div>
                            <div class="custom-align">
                                <div>Total votes: {{totalVotes}}</div>
                                <button type="button" class="btn mt-3">Vote</button>
                            </div>
                        </div>
                    </div>
                    <div v-html="afterPollDescription" class="poll-details"></div>
                </div>
            </div>
        </div> -->
        <div class="row poll-page-row">
            <div class="col-md-5 custom-column">
                <div class="poll-page-custom-card winner-animation">
                    <h5 class="text-color-in-winner">{{ pollTitle }}?</h5>
                    <div class="px-30-gap"></div>
                    <div class="custom-align">
                        <h5 class="flashing text-color-in-winner">W I N N E R</h5>
                        <img :src="'/../'+winnersThumbnail" class="winners-picture">
                        <br>
                        <h5 class="text-color-in-winner">{{winnersName}}</h5>
                    </div>
                    <div class="px-20-gap"></div>
                    
                </div>
            </div>
            <div class="col-md-7 custom-column" v-if="afterPollDescription !== ''">
                <div class="poll-page-custom-card">
                    <div v-html="afterPollDescription" class="poll-details"></div>
                    <!-- <div v-html="afterPollDescription" class="poll-details"></div> -->
                </div>
            </div>
        </div>
        <!-- <div class="poll-page-background">
            <div class="title_n_date">
                <h1 class="poll-title">{{pollTitle}}</h1>
                <div class="d-flex align-items-center">
                    <div class="poll-date">Uploaded {{startingDate}}</div>
                    <div class="distance-between-two"></div>
                    <div class="poll-date">Closing {{endingDate}}</div>
                </div>
            </div>
            <div class="px-20-gap"></div>
            <div v-html="beforePollDescription" class="poll-details"></div>
            <div class="px-20-gap"></div>
            

            <div class="card my-3 custom-card">
                <div class="card-body custom-card-body">
                <h5 class="card-title">{{ pollTitle }}</h5>
                <div class="px-20-gap"></div>
                <div  v-for="(poll, index) in pollsVoted" :key="index" class="polls-in-page">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadio1" :value="poll.id">
                        
                        <div class="total-votes">
                            <div class="votes-received-here" :style="{'width': poll.percent + '%'}"></div>
                            <label class="form-check-label d-flex justify-content-between align-items-center" for="exampleRadio1">
                                {{poll.polls}}
                                <div></div>
                                ~{{poll.percent}}%({{poll.votes}} votes)
                                
                            </label>
                            
                        </div>
                    </div>
                </div>
                <div class="px-20-gap"></div>
                <div class="custom-align">
                    <div>Total votes: {{totalVotes}}</div>
                    <button type="button" class="btn mt-3">Vote</button>
                </div>
                </div>
            </div>

            <div class="px-20-gap"></div>
            <div v-html="afterPollDescription" class="poll-details"></div>
            <div class="px-20-gap"></div>
            
        </div> -->

        <!-- <div style="width: 300px; background-color: red; position: relative; height: 30px;">
                <div id="gef" style="width: 10%; background-color: green; position: absolute; top: 0; left: 0; height: 30px;"></div>
                <div style="position: absolute; top: 0; left: 12%;">abcd</div>
            </div> -->
    </div>
    
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return{
                pollId: this.$route.params.pollid,
                pollFound: null,
                pollTitle: '',
                whichIndustry: '',
                startingDate: '',
                endingDate: '',
                publishedDate: '',
                imagesFound: [],
                totalVotes: '',
                thumbnail: '',
                winnersThumbnail: '',
                winnersName: '',
                afterPollDescription: '',
                token: localStorage.getItem('token'),
                userEmail: '',
            }
        },

        created() {
            this.getPollInfo();
            window.scrollTo(0, 0);
        },

        methods: {
            getPollInfo(){
                const formData = new FormData();
                this.pollId = this.pollId.replace(":", "");
                formData.append('pollId', this.pollId);
                axios.post('/api/get-poll-winner-info', formData)
                .then(response => {
                    if(response.data.success == true){
                        this.pollFound = true;
                        this.pollTitle = response.data.title_n_other_info.poll_title;
                        this.afterPollDescription = response.data.title_n_other_info.after_poll_description;
                        this.whichIndustry = response.data.title_n_other_info.which_industry;
                        this.startingDate = moment(response.data.title_n_other_info.starting_date).format('MMM D, YYYY h:mm A');
                        this.endingDate = response.data.title_n_other_info.ending_date;
                        this.publishedDate = moment(response.data.title_n_other_info.updated_at).format('MMM D, YYYY h:mm A');
                        // this.publishedDate = this.beautifyTime(response.data.title_n_other_info.updated_at);
                        this.winnersName = response.data.title_n_other_info.winners_name;
                        console.log(response.data );
                        
                        
                        this.totalVotes = response.data.total_votes;
                        this.thumbnail = response.data.images_uploaded[0].placeholder;
                        this.winnersThumbnail = response.data.images_uploaded[2].placeholder;
                        
                    }
                    if(response.data.success == false && response.data.message == "Found error while fetching data"){

                    }
                    if(response.data.success == false && response.data.message == "Poll not found"){
                        // this.$router.push('/*');
                        this.pollFound = false;
                    }
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
            },

            beautifyTime(timestamp) {
                timestamp = Date.parse(timestamp) / 1000;
                const now = Date.now() / 1000;
                const diff = Math.floor(now - timestamp);
                if (diff < 60) {
                    return 'published now';
                } else if (diff < 3600) {
                    const minutes = Math.floor(diff / 60);
                    return `published ${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else if (diff < 86400) {
                    const hours = Math.floor(diff / 3600);
                    return `published ${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    const days = Math.floor(diff / 86400);
                    return `published ${days} day${days > 1 ? 's' : ''} ago`;
                }
            }

            
            
        }
    }
</script>
