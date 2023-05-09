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
        <div class="poll-page-background">
            <!-- <div class="card my-3" v-for="(poll, index) in allPolls" :key="index">
                <div class="card-body">
                <span class="card-title">{{poll.poll_title}} (Closing at {{poll.ending_date}})</span>
                    <div v-for="(tag, indexT) in poll.poll_tags" :key="indexT" style="display: inline-block;">
                        {{tag.polls}} ({{tag.votes}} votes)
                        <div v-if="indexT !== poll.poll_tags.length - 1" style="display: inline-block;">, </div>
                    </div>
                </div>
            </div> -->

            <div v-for="(poll, index) in allPolls" :key="index">
                <div class="card my-3 custom-card-border">
                    <div class="which-industry">{{poll.which_industry}}</div>
                    <div class="card-body">
                        <h4 class="card-title custom-card-title">
                        {{poll.poll_title}} (Closing at <span>{{poll.ending_date}}</span>)
                        </h4>
                        <div v-for="(tag, indexT) in poll.poll_tags" :key="indexT" class="card-name-n-votes">
                            <span v-if="indexT !== poll.poll_tags.length - 1">
                                <b>{{tag.polls}}</b>({{tag.votes}} votes),&nbsp;
                            </span>
                            <span v-else>
                                <b>{{tag.polls}}</b>({{tag.votes}} votes)
                            </span>
                            <!-- <span v-if="indexT !== poll.poll_tags.length - 1" style="font-family: 'Lato', sans-serif; color: #6c757d; font-size: 14px;">,&nbsp;</span> -->
                        </div>
                    </div>
                </div>
                <div v-if="index%4==0">
                    ad
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                allPolls: [],
                pollFound: null,

            }
        },

        created() {
            this.getAllPolls();
        },

        methods: {
            getAllPolls(){
                axios.get('/api/get-all-poll')
			        .then(response => {
			          	if(response.data.success == true){
                            this.pollFound = true;
                            
                            response.data.all_polls.forEach(item => {
                                // item.all_tags = response.data.all_tags;
                                this.allPolls.push(item);
                            });
                            console.log(this.allPolls);
                        }
                        else if(response.data.success == false && response.data.message == "No polls uploaded yet"){
                            this.pollFound = false;
                        }
                        else{
                            this.pollFound = true;
                        }
			        })
			        .catch(error => {
			          	console.log(error);
			        });
            }
        }
    }
</script>
