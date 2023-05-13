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
            <div class="col-md-6">
                <div>
                    <span>Polls ending</span>
                    <hr>
                </div>
                <div v-if="allPollFound == true">
                    <div v-for="(poll, index) in allPolls" :key="index">
                        <div class="card my-3 custom-card-border">
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
                        </div>
                        <div v-if="index%3==0">
                            ad
                        </div>
                    </div>
                    
                </div>
            
            </div>
            <div class="col-md-6" >
                <div>
                    <span>Results</span>
                    <hr>
                </div>
                <div v-if="resultPollsFound == true">
                    <div v-for="(poll, index) in resultAllPolls" :key="index">
                        <div class="card my-3 custom-card-border">
                            <div class="which-industry"></div>
                            <div class="card-body d-flex">
                                <div>
                                    <img :src="'/../'+poll.thumbnail_image" class="thumbnail-images-in-list-of-polls">
                                </div>
                                <div class="thumbnail-texts-in-list-of-polls">
                                    <h4 class="card-title custom-card-title">
                                    {{poll.poll_title}} (Published at <span>{{poll.updated_at}}</span>)
                                    </h4>
                                    
                                    ..See more
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                industryName: this.$route.params.industry,
                allPolls: [],
                pollFound: null,
                allPollFound: null,
                resultAllPolls: [],
                resultPollsFound: null,

            }   
        },

        created() {
            this.getAllPolls();
            this.getlistOfResultPolls();
        },

        methods: {
            getAllPolls(){
                const formData = new FormData();
                this.industryName = this.industryName.replace(":", "");
                formData.append('industryName', this.industryName);
                axios.post('/api/get-all-poll-industry-wise', formData)
                .then(response => {
                    if(response.data.success == true){
                        this.allPollFound = true;
                        
                        response.data.all_polls.forEach(item => {
                            // item.all_tags = response.data.all_tags;
                            this.allPolls.push(item);
                        });
                        console.log(this.allPolls);
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
                const formData = new FormData();
                this.industryName = this.industryName.replace(":", "");
                formData.append('industryName', this.industryName);
                axios.post('/api/get-result-list-poll-industry-wise', formData)
                .then(response => {
                    if(response.data.success == true){
                        this.resultPollsFound = true;
                            
                        response.data.all_poll_result.forEach(item => {
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
            }
        }
    }
</script>
