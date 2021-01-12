<template>
    <div>
        <notifications group="foo" />
        <div class="row">
            <!-- Form -->
            <div class="col-lg-5">
                <!-- Event -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Event</label>
                            <input type="text" id="eventTitle" name="eventTitle" class="form-control" v-model="form.eventTitle" />
                        </div>
                    </div>
                </div>

                <!-- From-To -->
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>From</label>
                            <date-picker valueType="format" id="dateFrom" name="dateFrom" v-on:change="updateDays" v-model="form.eventDateFrom"></date-picker>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>To</label>
                            <date-picker valueType="format" id="dateTo" name="dateTo" v-model="form.eventDateTo" ></date-picker>
                        </div>
                    </div>
                </div>

                <!-- Days -->
                <div class="row mt-1">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkMon" value="Mon" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkMon">Mon</label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkTue" value="Tue" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkTue">Tue</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkWed" value="Wed" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkWed">Wed</label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkThu" value="Thu" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkThu">Thu</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkFri" value="Fri" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkFri">Fri</label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkSat" value="Sat" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkSat">Sat</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkSun" value="Sun" v-model="form.eventDays">
                                    <label class="form-check-label" for="chkSun">Sun</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <button v-on:click="submitForm()" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>


            <!-- Display List -->
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row border-bottom">
                            <div class="col-lg-12 p-2"><h2>{{mnth}} {{yr}}</h2></div>
                        </div>

                        <div class="row border-bottom" v-for="ad in arrDays" :id="`res${ad.day}`" :key="ad.day">
                            <div class="col-lg-1 p-2">{{ ad.day }}</div>
                            <div class="col-lg-2 p-2" :id="`lbl${ad.day}`">{{ ad.lbl }}</div>
                            <div class="col-lg-9 p-2" :id="`d${ad.day}`"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        data() {
            return {
                eTitle: '',
                mnth: 'January',
                yr: '2021',
                numDays: 31,
                api_url: process.env.MIX_PROD_API_URL,
                days: ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'],
                monthName: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ],
                form: {
                    eventTitle: '',
                    eventDateFrom: '',
                    eventDateTo: '',
                    eventDays: [],
                }
            };
        },
        computed: {
            arrDays:function(){
                var x = 0;
                var arrDays = [];

                for(var i=1; i<=this.numDays; i++) {
                    (x == 7) ? x = 0 : x = x;
                    arrDays.push({ day:i, lbl:this.days[x] });
                    x++;
                }

                return arrDays;
            }
        },
        methods: {
            sortDays(days) {
                var dd = new Date(this.form.eventDateFrom);
                var date = new Date(dd.getFullYear() + '-' + (dd.getMonth() + 1) + '-' + parseInt('01'));
                var daysOfWeek = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
                var today = date.getDay();
                for (var i=0; i<today; i++) daysOfWeek.push(daysOfWeek.shift());
                return daysOfWeek.filter(function(d) { return days.indexOf(d) >= 0; });
            },
            getDaysInMonth(month,year){
                return new Date(year, month, 0).getDate();
            },
            updateDays(){
                let dFrom = new Date(this.form.eventDateFrom);
                this.numDays = this.getDaysInMonth(parseInt(dFrom.getMonth() + 1), dFrom.getFullYear());
                this.days = this.sortDays(this.days);
                this.mnth = this.monthName[dFrom.getMonth()];
                this.yr = dFrom.getFullYear();
            },
            updateList(){
                let dFrom = new Date(this.form.eventDateFrom);
                let dTo = new Date(this.form.eventDateTo);
                let dDay = this.form.eventDays;

                for(var n=dFrom.getDate(); n<=dTo.getDate(); n++){
                    for(var x=0; x<dDay.length; x++){
                        for(var i=0; i<this.days.length; i++){
                            if(document.getElementById(`chk${this.days[i]}`).checked == true){
                                if(dDay[x] == document.getElementById(`lbl${n}`).innerText){
                                    this.eTitle = this.form.eventTitle;
                                    document.getElementById(`d${n}`).innerText = this.eTitle
                                    document.getElementById(`res${n}`).style.backgroundColor = "#e3fbe3"
                                }
                            } else {
                                if(this.days[i] == document.getElementById(`lbl${n}`).innerText){
                                    document.getElementById(`d${n}`).innerText = "";
                                    document.getElementById(`res${n}`).style.backgroundColor = "#ffffff"
                                }
                            }
                        }
                    }
                }

                // Vue alert message once success
                this.$notify({
                    group: 'foo',
                    title: '',
                    text: 'Event successfully saved',
                    type: 'success',
                    duration: 10000,
                });
            },
            submitForm(){
                this.updateDays();
                this.updateList();
                axios.post(this.api_url + '/event', this.form)
                    .then(res => {
                        console.log('Saved successfully');
                    })
                    .catch((error) => {
                        console.log('Error found');
                        console.log(error);
                    });
            },
        },
        components: { 
            Datepicker 
        },
    }
</script>