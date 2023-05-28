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
                        <div class="poll-date">Uploaded - {{startingDate}}</div>
                        <div class="distance-between-two custom-align">|</div>
                        <div class="poll-date">Closing - {{endingDate}}</div>
                    </div>
                </div>
                <div class="px-15-gap"></div>
            </div>
        </div>
        <div class="px-10-gap"></div>
        <!-- <div class="styling-link font-selected">
            <router-link to="/" class="navigator-link">Home</router-link><i class='fas fa-angle-right'></i>
            <router-link :to="'/polls/'+whichIndustry" class="navigator-link capitalized">{{whichIndustry}}</router-link><i class='fas fa-angle-right'></i>
            <router-link :to="'/poll/'+pollId" class="navigator-link">{{pollId}}</router-link>
        </div> -->
        <div class="row poll-page-row">
            <div class="col-md-6">
                <div class="styling-link font-selected">
                    <router-link to="/" class="navigator-link">Home</router-link><i class='fas fa-angle-right'></i>
                    <router-link :to="'/polls/'+whichIndustry" class="navigator-link capitalized">{{whichIndustry}}</router-link><i class='fas fa-angle-right'></i>
                    <router-link :to="'/poll/'+pollId" class="navigator-link">{{pollId}}</router-link>
                </div>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <!-- <button type="button" class="btn btn-primary">
                    <i class="fas fa-share"></i> Share
                </button> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary share-button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="fas fa-share-alt"></i> Share</span>
                    </button>
                    <ul class="dropdown-menu share-dropdown-button">
                        <li>
                            <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" title="facebook" style="margin-right: 0px;" @click="shareOnFacebook">
                                <img src="/logo/Facebook-logo.png" alt="Facebook Share" style="height: 32px;width: 51px;">
                            </a>
                        
                            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" title="twitter" style="margin-right: 8px;" @click="shareOnTwitter">
                                <img src="/logo/Twitter-logo.svg.png" alt="Twitter Share" style="height: 26px;width: 33px;">
                            </a>
                        
                            <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" title="instagram" @click="shareOnInstagram">
                                <img src="/logo/Instagram_logo_2016.svg.webp" alt="LinkedIn Share" style="height: 27px;width: 27px;">
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" title="facebook" style="margin-right: 0px;" @click="shareOnFacebook">
                    <img src="/logo/Facebook-logo.png" alt="Facebook Share" style="height: 32px;width: 51px;">
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" title="twitter" style="margin-right: 8px;" @click="shareOnTwitter">
                    <img src="/logo/Twitter-logo.svg.png" alt="Twitter Share" style="height: 26px;width: 33px;">
                </a>

                <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" title="instagram" @click="shareOnInstagram">
                    <img src="/logo/Instagram_logo_2016.svg.webp" alt="LinkedIn Share" style="height: 27px;width: 27px;">
                </a> -->
            </div>
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
                <div class="poll-page-custom-card">
                    <h5>{{ pollTitle }}?</h5>
                    <div class="px-30-gap"></div>
                    <div  v-for="(poll, index) in pollsVoted" :key="index" class="polls-in-page">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadio1" @change="selectedOptionToVote(poll.id)" :value="poll.id">
                            
                            <div class="total-votes">
                                <div class="votes-received-here" :style="{'width': poll.percent + '%'}"></div>
                                <label class="form-check-label d-flex justify-content-between align-items-center" for="exampleRadio1">
                                    {{poll.polls}}
                                    <div></div>
                                    ~{{poll.percent}}%({{formatNumber(poll.votes)}} votes)
                                    
                                </label>
                                <!-- <div style="width: 100%;height: 100%;background-color: rgb(72, 175, 72);" :style="{'width': poll.percent + '%'}" v-if="poll.id == 3"></div> -->
                                <!-- <span class="bi bi-check"></span> -->
                                
                            </div>
                            <div class="px-10-gap"></div>
                        </div>
                    </div>
                    
                    <div class="custom-align">
                        <div>Total votes: {{formatNumber(totalVotes)}}</div>
                        <!-- <h4 v-html="voteMessage" style="height: 30px;"></h4> -->
                        <button type="button" class="btn mt-3" @click="preCheckBeforeVote()" :disabled="disableVote">Vote</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7 custom-column" v-if="beforePollDescription !== ''">
                <div class="poll-page-custom-card">
                    <div v-html="beforePollDescription" class="poll-details"></div>
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
    import { useToast } from 'vue-toastification';
    const toast = useToast();
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
                totalVotes: 0,
                thumbnail: '',
                idSelectedToVote: '',
                tableNameStartsWith: '',
                disableVote: false,
                token: localStorage.getItem('token'),
                userEmail: '',
                voteMessage: '',
            }
        },

        created() {
            const protocol = window.location.protocol; // e.g., "http:" or "https:"
            const hostname = window.location.hostname; // e.g., "www.example.com"
            const port = window.location.port; // e.g., "8080" (if exists)
            const url = `${protocol}//${hostname}${port ? `:${port}` : ''}`;
            // console.log(url);
            this.getPollInfo();
            window.scrollTo(0, 0);
        },

        methods: {
            shareOnFacebook() {
                const protocol = window.location.protocol; // e.g., "http:" or "https:"
                const hostname = window.location.hostname; // e.g., "www.example.com"
                const port = window.location.port; // e.g., "8080" (if exists)
                const url = `${protocol}//${hostname}${port ? `:${port}` : ''}`;

                const currentLink = window.location.href;
                const title = this.pollTitle;
                const description = 'Your Description';
                const imageUrl = url+'/'+this.thumbnail;
                const pageUrl = currentLink;

                const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}&quote=${encodeURIComponent(description)}&hashtag=${encodeURIComponent(title)}&picture=${encodeURIComponent(imageUrl)}`;
                // const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentLink)}`;
                window.open(shareUrl, '_blank');
            },

            shareOnTwitter() {
                const protocol = window.location.protocol; // e.g., "http:" or "https:"
                const hostname = window.location.hostname; // e.g., "www.example.com"
                const port = window.location.port; // e.g., "8080" (if exists)
                const url = `${protocol}//${hostname}${port ? `:${port}` : ''}`;

                const currentLink = window.location.href;
                const title = this.pollTitle+'\r\n';
                const description = 'Your Description, Check out this link! ';
                const imageUrl = url+'/'+this.thumbnail;
                const pageUrl = currentLink;
                const twitterUsername = 'Company_UserName';

                const text = `${title} ${description} ${imageUrl}`;

                const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(pageUrl)}&text=${encodeURIComponent(text)}&via=${twitterUsername}`;
                // const text = "Check out this link!";
                // const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentLink)}&text=${encodeURIComponent(text)}`;
                // const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentLink)}`;
                window.open(shareUrl, '_blank');
            },

            shareOnInstagram() {
                const protocol = window.location.protocol; // e.g., "http:" or "https:"
                const hostname = window.location.hostname; // e.g., "www.example.com"
                const port = window.location.port; // e.g., "8080" (if exists)
                const url = `${protocol}//${hostname}${port ? `:${port}` : ''}`;

                const currentLink = window.location.href;
                const title = this.pollTitle;
                const description = 'Your Description';
                const imageUrl = url+'/'+this.thumbnail;
                const pageUrl = currentLink;
                const text = `Check out this link! ${imageUrl} ${title} ${description} ${pageUrl}`;
                const shareText = encodeURIComponent(text);
                const shareUrl = `https://www.instagram.com/?text=${shareText}`;
                // const shareText = encodeURIComponent(`Check out this link: ${currentLink}`);
                // const shareUrl = `https://www.instagram.com/?text=${shareText}`;
                window.open(shareUrl, '_blank');
            },
            formatNumber(number) {
                return number.toLocaleString();
            },

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
                        this.startingDate = moment(response.data.title_n_other_info.starting_date).format('D MMM YYYY h:mm A');
                        this.endingDate = moment(response.data.title_n_other_info.ending_date).format('D MMM YYYY');
                        this.tableNameStartsWith = response.data.title_n_other_info.table_name_starts_with;

                        console.log(response.data );
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

                        this.totalVotes = parseInt(response.data.total_votes);
                        
                        if(response.data.images_uploaded[0]){
                            this.thumbnail = response.data.images_uploaded[0].placeholder;
                        }
                        
                        
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

            selectedOptionToVote(id){
                console.log(id);
                this.idSelectedToVote = id;
            },

            checkIfUserLoggedin(){
                return new Promise((resolve, reject) => {
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
                                resolve(true);
                                // this.$router.push(`/`);
                                // this.userId = response.data.userInfoFromTk.id;
                            }
                            else{
                                resolve(false);
                            }
                        })
                        .catch(error => {
                            console.log(error);
                            resolve(false);
                        });
                    }
                    else{
                        //no token means no user logged in
                        resolve(false);
                        // console.log("no token in storage");
                    }
                });
            },

            preCheckBeforeVote(){
                // this.disableVote = true;
                // this.voteMessage = "";
                // if(this.token.length > 0){
                //     let value = await this.checkIfUserLoggedin();
                //     console.log("is he logged in: "+this.userEmail);
                //     if(value == true){
                //         this.voteNow();
                //     }
                //     else{
                //         this.disableVote = false;
                //         this.voteMessage = "<span style='color:red;'>You need to login.</span>";
                //         setTimeout(() => {
                //             this.voteMessage = "";
                //         }, 2000);
                        
                //     }
                // }
                // else{
                //     this.disableVote = false;
                //     this.voteMessage = "<span style='color:red;'>You need to login.</span>";
                //     setTimeout(() => {
                //         this.voteMessage = "";
                //     }, 2000);
                // }

                this.disableVote = true;
                // this.voteMessage = "";
                if(localStorage.getItem('token')){
                    if (this.token.length > 0) {
                        this.checkIfUserLoggedin().then((value) => {
                            console.log("Is he logged in: " + this.userEmail);
                            if (value === true) {
                                this.voteNow();
                            } 
                            else{
                                this.disableVote = false;
                                toast.error("You need to login.");
                                // this.voteMessage = "<span style='color:red;'>You need to login.</span>";
                                // setTimeout(() => {
                                //     this.voteMessage = "";
                                // }, 2000);
                            }
                        }).catch((error) => {
                            this.disableVote = false;
                            toast.error("You need to login.");
                            // this.voteMessage = "<span style='color:red;'>Server went down.</span>";
                            // setTimeout(() => {
                            //     this.voteMessage = "";
                            // }, 2000);
                        });
                    }
                    else{
                        this.disableVote = false;
                        toast.error("You need to login.");
                        // this.voteMessage = "<span style='color:red;'>You need to login.</span>";
                        // setTimeout(() => {
                        //     this.voteMessage = "";
                        // }, 2000);
                    }
                }
                else{
                    this.disableVote = false;
                    toast.error("You need to login.");
                }
            },

            voteNow(){
                
                if(this.idSelectedToVote == "" || this.idSelectedToVote == null){
                    this.disableVote = false;
                    toast.warning("Please select an option.")
                    // this.voteMessage = "<span style='color:red;'>Please select an option.</span>";
                    // setTimeout(() => {
                    //     this.voteMessage = "";
                    // }, 2000);
                }
                else{
                    const formData = new FormData();
                    formData.append("selected_id", this.idSelectedToVote);
                    formData.append("table_name_starts_with", this.tableNameStartsWith);
                    formData.append("email", this.userEmail);
                    axios.post('/api/vote-selected-candidate', formData)
                    .then(response => {
                        console.log(response);
                        this.pollsVoted = [];
                        if(response.data.success == true){
                            response.data.new_polls.forEach(item => {
                                
                                if(((item.votes / response.data.total_votes) * 100).toFixed(2) > 0){
                                    item.percent = ((item.votes / response.data.total_votes) * 100).toFixed(2);
                                }
                                else{
                                    item.percent = 0;
                                }
                                this.pollsVoted.push(item);
                            });
                            this.totalVotes = parseInt(response.data.total_votes);
                            toast.success(response.data.message);
                            // this.voteMessage = "<span style='color:green;'>"+response.data.message+"</span>";
                        }
                        this.disableVote = false;
                    })
                    .catch(error => {
                        console.log(error);
                        this.disableVote = false;
                    });
                }
            }
            
        }
    }
</script>
