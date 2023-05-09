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
        <div class="styling-link font-selected">
            <router-link to="/" class="navigator-link">Home</router-link><i class='fas fa-angle-right'></i>
            <router-link to="" class="navigator-link">{{whichIndustry}}</router-link><i class='fas fa-angle-right'></i>
            <router-link :to="'/poll/'+pollId" class="navigator-link">{{pollId}}</router-link>
        </div>
        <div class="poll-page-background">
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
            <!-- <div  v-for="(poll, index) in pollsVoted" :key="index" class="polls-in-page">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadio1" :value="poll.polls">
                    <label class="form-check-label" for="exampleRadio1">
                        {{poll.polls}}
                    </label>
                </div>
            </div> -->

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
            <!-- <div>{{whichIndustry}}</div> -->
            <!-- <img :src="imagesFound[1]"> -->


            <!-- <div style="width: 300px; background-color: red; position: relative; height: 30px;">
                <div id="gef" style="width: 10%; background-color: green; position: absolute; top: 0; left: 0; height: 30px;"></div>
                <div style="position: absolute; top: 0; left: 12%;">abcd</div>
            </div> -->



        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return{
                pollId: this.$route.params.pollid,
                pollFound: null,
                pollTitle: '',
                beforePollDescription: '',
                afterPollDescription: '',
                whichIndustry: '',
                startingDate: '',
                endingDate: '',
                pollsVoted: [],
                imagesFound: [],
                totalVotes: '',
            }
        },

        created() {
            this.getPollInfo();
        },

        mounted() {
            
        },

        methods: {
            getPollInfo(){
                const formData = new FormData();
                this.pollId = this.pollId.replace(":", "");
                formData.append('pollId', this.pollId);
                axios.post('/api/get-poll-info', formData)
                .then(response => {
                    if(response.data.success == true){
                        this.pollFound = true;
                        this.pollTitle = response.data.title_n_other_info.poll_title;
                        this.beforePollDescription = response.data.title_n_other_info.before_poll_description;
                        this.afterPollDescription = response.data.title_n_other_info.after_poll_description;
                        this.whichIndustry = response.data.title_n_other_info.which_industry;
                        this.startingDate = response.data.title_n_other_info.starting_date;
                        this.endingDate = response.data.title_n_other_info.ending_date;
                        // let pollObject = {
                        //     "polls": "",
                        //     "votes": 0,
                        //     "percent": 0
                        // };
                        console.log(this.beforePollDescription);
                        response.data.polls_n_counts.forEach(item => {
                            // pollObject.polls = item.polls;
                            // pollObject.votes = item.votes;
                            // if(((item.votes / response.data.total_votes) * 100).toFixed(2) > 0){
                            //     pollObject.percent = ((item.votes / response.data.total_votes) * 100).toFixed(2);
                            // }
                            // else{
                            //     pollObject.percent = 0;
                            // }

                            if(((item.votes / response.data.total_votes) * 100).toFixed(2) > 0){
                                item.percent = ((item.votes / response.data.total_votes) * 100).toFixed(2);
                            }
                            else{
                                item.percent = 0;
                            }
                            this.pollsVoted.push(item);
                        });
                        
                        this.totalVotes = response.data.total_votes;
                        // response.data.images_uploaded.forEach(item => {
                        //     this.imagesFound.push(item);
                        // });
                        // let blob = "";
                        // response.data.images_uploaded.forEach(item => {
                        //     // blob = new Blob([item.placeholder]);
                        //     // blob = new Blob([new Uint8Array(item.placeholder)]);
                        //     console.log(item.placeholder);
                        //     this.imagesFound.push("/../"+item.placeholder);
                        // });

                        // console.log(this.imagesFound);
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

            
        }
    }
</script>
