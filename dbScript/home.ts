import { Component } from '@angular/core';
import { NavController, SelectPopover, Alert } from 'ionic-angular';
import { ToastController , AlertController,LoadingController, Events  } from 'ionic-angular';
import { DashboardPage } from '../dashboard/dashboard';
import { FormBuilder, FormGroup, Validators,FormControl } from '@angular/forms';
import { Storage } from '@ionic/storage';
import { LocalserviceProvider } from '../../providers/localservice/localservice';
import { DatabaseProvider } from '../../providers/database/database';
import { NetworkconnectProvider } from '../../providers/networkconnect/networkconnect';
import { Network } from '@ionic-native/network';
import { RestserviceProvider } from '../../providers/restservice/restservice';
import { SuperadminloginPage } from '../superadminlogin/superadminlogin';


@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  private alert: Alert;
  private db ;
  loginForm: FormGroup;
  hourText:number;
  minText:number;
  secText:number;
  syncLoader:boolean = false;
  syncLoader2:boolean = false;
  signInLoader:boolean = false;
  countDisplay:any;
  deviceuuidKey;
  ListMobileData = [];
  ListBreakDownData = [];
  ListLocalTransData = [];
  totalnoTableToSync = 5;
  totalnoTableToSyncDone = 0;

  constructor(
    public navCtrl: NavController ,
    private localservice:LocalserviceProvider ,
    private storage: Storage , 
    private databaseservice:DatabaseProvider,
    private alertCtrl: AlertController,
    public networkProvider:NetworkconnectProvider,
    private toastCtrl: ToastController,
    public events: Events,
    private network: Network,
    private liveservice: RestserviceProvider
    
     
    ) {
      //this.deviceuuidKey = this.localservice.getDeviceUUID();
        this.loginForm = new FormGroup({
          driverPassword: new FormControl('')
        });
      }


      ionViewDidLoad() {

       // this.getMobileList();
        /* console.log('ionViewDidLoad DashboardPage');
        this.getLocation();
        this.getProject();
        this.getDriver();
        this.getVehicle();
        this.getVehicleType();
        */
    
       
      
    
      }

    getDeviceKey()
    { 
      let devicekey
      devicekey = this.localservice.getDeviceUUID();
      this.presentAlert("Your Device Key",devicekey,"OK");
    }

 /*
getMobileList() {
    this.databaseservice.getMobileList().then((data: any) => {
    this.ListMobileData = data;
  }, (error) => {
    console.log(error);
  })
}
*/

  signIn(){
    this.signInLoader = true;
    this.storage.clear();
    let deviceuuid = this.localservice.getDeviceUUID();
   // alert("Device UUID "+this.localservice.getDeviceUUID());
    this.db =  this.databaseservice.getDbConnection();
    let driverPass = this.loginForm.get("driverPassword").value;
    // addedd project is_active 29.03.2019
    let sql_check_mobile = 'SELECT * FROM mobile_master INNER JOIN vehicle_master ON vehicle_master.mobile_uniq_id = mobile_master.mobile_id INNER JOIN project_master ON project_master.project_id=vehicle_master.project_id WHERE mobile_uuid = "' + deviceuuid + '" AND project_master.is_active="Y" AND mobile_master.is_active="Y" AND vehicle_master.is_active="Y"';
   // console.log(sql_check_mobile);
   //alert(sql_check_mobile);
    this.db.executeSql(sql_check_mobile, []).then((data) => {
     //console.log(sql_check_mobile);
      if (data.rows.length > 0) {
          let mobileid = data.rows.item(0).mobile_id;
          let vehicleproject = data.rows.item(0).project_nickname;
          console.log("Veichel Project Code:"+vehicleproject);
          let sql_verify_driver = 'SELECT * FROM driver_master WHERE driver_password = "' + driverPass + '" LIMIT 1';
         // alert(sql_verify_driver);
          this.db.executeSql(sql_verify_driver, []).then((data) => {
           // alert("Length" + data.rows.length);
            if (data.rows.length > 0) {

              console.log("Driver Project Code:"+data.rows.item(0).working_project_id);
                  if(vehicleproject==data.rows.item(0).working_project_id){
                        this.storage.set('drivercode', data.rows.item(0).driver_code );
                        this.storage.set('mobileid',  mobileid );
                        this.storage.set('isLoggedIn',  true );
                        this.signInLoader = false;
                        this.navCtrl.setRoot(DashboardPage);

                  }else{
                        this.signInLoader = false;
                        this.presentAlert("Authentication Failed" , "Please check driver project and try again." , "OK");
                  }

            }
            else {
              this.signInLoader = false;
              this.presentAlert("Authentication Failed" , "Please check your pin code and try again." , "OK");
            }
           // resolve(mobileArray);
          }, (error) => {
            
            //reject(error);
          })


      }
      else {
        this.signInLoader = false;
        this.presentAlert("Unrecognized or Inactive Device" , "Contact to admin support team" , "OK");
      }
     // resolve(mobileArray);
    }, (error) => {
      //alert(error);
      console.log(error);
      this.presentAlert("Synchronize" , "Try to synchronize first then login with your pin code" , "OK");
      this.signInLoader = false;
     // reject(error);
    })



  }





/*
  syncMasterDatas() {

            this.syncLoader = true;
            let secondCount = 60;

            let states = {};
            states[this.network.Connection.UNKNOWN]  = 'Unknown connection';
            states[this.network.Connection.ETHERNET] = 'Ethernet connection';
            states[this.network.Connection.WIFI]     = 'WiFi connection';
            states[this.network.Connection.CELL_2G]  = 'Cell 2G connection';
            states[this.network.Connection.CELL_3G]  = 'Cell 3G connection';
            states[this.network.Connection.CELL_4G]  = 'Cell 4G connection';
            states[this.network.Connection.CELL]     = 'Cell generic connection';
            states[this.network.Connection.NONE]     = 'No network connection';

            if(this.network.type == this.network.Connection.NONE) {
              this.presentAlert("Connection Error","Please check your internet connection.","OK");
              this.syncLoader = false;
            }
            else {
              this.databaseservice.getBreakDownData('N').then((data: any) => {
              this.ListBreakDownData = data;
          
                let resulStatus;
                this.liveservice.updateBreakDownData(this.ListBreakDownData).then(data => {
                 
                  resulStatus = data;
                  if(resulStatus.msg_data=="SUCCESS" && resulStatus.msg_status==200) {
                   // this.database.updateLocalTransDataByDriverCode(this.driverCode);
                   // this.syncLoader = false;
                   this.databaseservice.updateBreakDownDataAfterSync();

                   Promise.all(
                    [
                      this.databaseservice.createMasterTables(),
                      this.databaseservice.getProjectMaster_Live(),
                      this.databaseservice.getVehicleMaster_Live(),
                      this.databaseservice.getDriverMaster_Live(),
                      this.databaseservice.getVehicleTypeMaster_Live(),
                      this.databaseservice.getMobileMaster_Live()
                    ]
                    ).then(data => {
                     
                  
              
                      let interval = setInterval(()=>{
                        secondCount--;
                        this.countDisplay = secondCount;
              
                        if(secondCount==0){
                          this.syncLoader = false;
                          secondCount = 60;
                          clearInterval(interval);
                        }
              
                        },1000);
                    
              
                      
                  });
                }
                  
                });
            
              }, (error) => {
              console.log(error);
            })


            }
}
*/



syncMasterDatas() {
  
  this.totalnoTableToSyncDone=0;
    let states = {};
    states[this.network.Connection.UNKNOWN]  = 'Unknown connection';
    states[this.network.Connection.ETHERNET] = 'Ethernet connection';
    states[this.network.Connection.WIFI]     = 'WiFi connection';
    states[this.network.Connection.CELL_2G]  = 'Cell 2G connection';
    states[this.network.Connection.CELL_3G]  = 'Cell 3G connection';
    states[this.network.Connection.CELL_4G]  = 'Cell 4G connection';
    states[this.network.Connection.CELL]     = 'Cell generic connection';
    states[this.network.Connection.NONE]     = 'No network connection';
    if(this.network.type == this.network.Connection.NONE) {
      this.presentAlert("Connection Error","Please check your internet connection.","OK");
      this.syncLoader = false;
    }
    else if(this.network.type == this.network.Connection.CELL_2G){
      this.presentAlert("Connection Error","You must have 3G or WiFi Connection for synchronization.","OK");
      this.syncLoader = false;
    }
    else{
  
      let disconnectSubscription = this.network.onDisconnect().subscribe(() => {
       this.presentAlert("Connection Error","Synchronization failed.No Internet connection.Try again...","OK");
       this.syncLoader = false;
       disconnectSubscription.unsubscribe();
        return false;
      });
      
      this.syncLoader = true;
      this.databaseservice.createMasterTables();
      this.databaseservice.deleteTableData();
      this.databaseservice.getBreakDownData('N').then((data: any) => {
        this.ListBreakDownData = data;
          let resulStatus;
          this.liveservice.updateBreakDownData(this.ListBreakDownData).then(data => {
            resulStatus = data;
            if(resulStatus.msg_data=="SUCCESS" && resulStatus.msg_status==200) {
             
              
              // GET LIVE DATA AND IMPORT TO LOCAL DB ::: DRIVER MASTER
              this.liveservice.getDriverMaster().then(data=> {
    
                let resultDriver; let driverData = [];
                resultDriver = data;
                driverData.push(resultDriver.result_data);
                let drivers = driverData[0];
    
                console.log("Driver Query");
                console.log(drivers);
    
                const driverQueries: string[] = drivers.map(driver => `INSERT INTO driver_master values(${driver.driver_id}, '${driver.driver_code}','${driver.driver_name}','${driver.working_project_id}','${driver.driver_password}',${driver.vehicle_type_id},'${driver.is_active}')`);
    
    
    
                try {
                  let driverInsertstatus = this.databaseservice.getDbConnection().sqlBatch(driverQueries);
                  
    
    
                  // MOBILE MASTRE LIVE CALL ::: mobile_master
                  this.liveservice.getMobileMaster().then(data=> {
                        this.totalnoTableToSyncDone = 1;
                        let resultMobile;
                        resultMobile = data;
                        let mobileData = [];
                        mobileData.push(resultMobile.result_data);
                        let mobileMasterArray =  mobileData[0];
                        
                        const mobileQueries: string[] = mobileMasterArray.map(mobile => `INSERT INTO mobile_master values(${mobile.mobile_id}, '${mobile.mobile_uuid}','${mobile.mobile_no}','${mobile.is_active}','${mobile.is_new}')`);
    
                        console.log("mobileMasterArray Array Import");
                        console.log(mobileQueries);
                        try {
                          let insertMobileStatus = this.databaseservice.getDbConnection().sqlBatch(mobileQueries);
                          console.log(insertMobileStatus);
    
    
                          // VEHICLE MASTER LIVE CALL ::: vehicle_master
                          this.liveservice.getVehicleMaster().then(data => {
                            this.totalnoTableToSyncDone = 2;
                            let resultVehicle;
                            let vehicleData = [];
                            resultVehicle = data;
                            vehicleData.push(resultVehicle.result_data);
                            let vehicleMasterArray = vehicleData[0];
    
                            console.log("vehicleMasterArray Query");
                            console.log(vehicleMasterArray);
    
                            const vehicleQueries: string[] = vehicleMasterArray.map(vehicle => `INSERT INTO vehicle_master values(${vehicle.vehicle_id}, '${vehicle.equipment_id}','${vehicle.equipment_name}','${vehicle.equipment_model}',${vehicle.vehicle_type_id},'${vehicle.project_id}','${vehicle.mobile_uniq_id}','${vehicle.is_active}')`);
    
                            console.log("vehicleMasterArray Array Import");
                            console.log(vehicleQueries);
    
                            try {
                               let vehicleInsertStatus = this.databaseservice.getDbConnection().sqlBatch(vehicleQueries);
    
                              
                               this.liveservice.getProjects().then(data => {
                                this.totalnoTableToSyncDone = 3;
    
                                let resultProject;
                                let projectData = [];
                                 resultProject = data;
                                 projectData.push(resultProject.result_data);
                                 let projectArray = projectData[0];
                                 
                                 console.log("project Query");
                                 console.log(projectArray);
    
                                 const projectQueries: string[] = projectArray.map(project => `INSERT INTO project_master values(${project.project_id}, '${project.project_name}','${project.project_nickname}','${project.location_id}','${project.is_active}')`);
    
                                 console.log("projectQueries Array Import");
                                 console.log(projectQueries);
    
                                 try {
                                        let projectInsertStatus = this.databaseservice.getDbConnection().sqlBatch(projectQueries);
    
                                        this.liveservice.getVehicleTypeMaster().then(data => {
                                              this.totalnoTableToSyncDone = 4;
                                              let resultVehicleType; let vehicleTypeData = [];
                                              resultVehicleType = data;
                                              
                                              vehicleTypeData.push(resultVehicleType.result_data);
                                              let vehicleTypeArray = vehicleTypeData[0];
    
                                              console.log("vehicleTypeArray Query");
                                              console.log(vehicleTypeArray);
    
                                              const vehicleTypeQueries: string[] = vehicleTypeArray.map(vehicletype => `INSERT INTO vehicle_type values(${vehicletype.vehicle_type_id}, '${vehicletype.vehicle_type}')`);
    
                                              console.log("vehicleTypeArray Array Import");
                                              console.log(vehicleTypeQueries);
    
                                              try {
                                                 let vehicleTypeStatus = this.databaseservice.getDbConnection().sqlBatch(vehicleTypeQueries);
  
  
                                                //  console.log("Sync Done");
                                                //  this.totalnoTableToSyncDone = 5;
                                                //  this.syncLoader = false;
                                                console.log("try superviser_master block");
  
                                                // SUPER ADMIN BLOCK ::: superviser_master
                                                this.liveservice.getSupervisoreMaster().then(data => {
                                                  console.log("superviser_master block");
                                                  this.totalnoTableToSyncDone = 5;
                                                  let resultSupervisor; let supervisorData = [];
                                                  resultSupervisor = data;
  
                                                  supervisorData.push(resultSupervisor.result_data);
                                                  let supervisorArray = supervisorData[0];
  
                                                  const supervisorQueries: string[] = supervisorArray.map(supervisor => `INSERT INTO supervisor_master values(${supervisor.supervisor_id}, '${supervisor.emp_code}', '${supervisor.name}', '${supervisor.pin}', '${supervisor.project_id}', '${supervisor.is_active}', '${supervisor.is_new}')`);
  
                                                  console.log("supervisorArray Array Import");
                                                  console.log(supervisorQueries);
  
                                                  try{
                                                    
                                                    let supervisorStatus = this.databaseservice.getDbConnection().sqlBatch(supervisorQueries);
                                                    console.log("Sync Done");
                                                    this.totalnoTableToSyncDone = 6;
                                                    this.syncLoader = false;
  
                                                  }
                                                  catch (error) {
                                                    this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
                                                    this.syncLoader = false;
                                                    console.log('supervisorArray insert failed: ' );
                                                    console.log(error);
                                                  }
                                          
  
                                                }); // end of this.liveservice.getSupervisoreMaster()
  
                                              
                                              
                                                } catch (error) {
                                                this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
                                                this.syncLoader = false;
                                                console.log('vehicleTypeQueries insert failed: ' );
                                                console.log(error);
                                              }
                                      
                                    
                                        });
    
    
                                 } catch (error) {
                                    this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
                                    this.syncLoader = false;
                                   console.log('Project insert failed: ' );
                                   console.log(error);
                                 }
                                 
                              }); // END OF this.liveservice.getProjects()
    
    
                            } catch (error) { // ERROR BLOCK Vehicle_master
                              this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
                              this.syncLoader = false;
                              console.log('Vehicle insert failed: ' );
                              console.log(error);
                            }
    
    
    
                          }); // end of  this.liveservice.getVehicleMaster()
                         
    
    
    
    
                        } catch (error) { // mobile_master catch block
                          this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
                          this.syncLoader = false;
                          console.log('mobileQueries insert failed: ' );
                          console.log(error);
                        }
    
                  }) // end of this.liveservice.getMobileMaster()
    
          
                 
                } 
                catch (error) { // DRIVER MASTER SQL CATCH BLOCK
                  console.log('Driver insert failed: ' );
                  console.log(error);
                  this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
                  this.syncLoader = false;
                }
            }); // end of this.liveservice.getDriverMaster()
          } // end of updateBreakDownData SUCCESS
          else{
            this.presentAlert("Error","Connection Failed.Check your internet connection.","OK");
            this.syncLoader = false;
          }
            
          }, (error) => {
            this.presentAlert("Synchronization Error","Failed to synchronize.Try again...","OK");
            this.syncLoader = false;
            console.log(error);
            });  // end of this.liveservice.updateBreakDownData
      
        }, (error) => {
          this.presentAlert("Error","Http Request Error","OK");
          this.syncLoader = false;
          console.log(error);
      }) // end of this.databaseservice.getBreakDownData('N')
  
  
    }// end of network check
  
  
  
  
  
  
  }


/*
presentAlert(title,subtitle,btntext) {
  let isAlertStarted=false;
  let alert = this.alertCtrl.create({
    title: title,
    subTitle: subtitle,
    buttons: [btntext],
    cssClass: 'exitAppAlert'
  });
  alert.present();
}
*/

presentAlert(title,subtitle,btntext) {
  this.dismiss();
  this.alert = this.alertCtrl.create({
    title: title,
    subTitle: subtitle,
    buttons: [btntext],
    cssClass: 'exitAppAlert'
  });
  this.alert.present();
}

public dismiss() {
  if (this.alert){ this.alert.dismiss()};
}

gotoSuperAdmin(){
 // this.navCtrl.push(SuperadminloginPage);
 this.navCtrl.setRoot(SuperadminloginPage);
}



syncLocalTransDataToLive() {
  
  if(this.network.type == this.network.Connection.NONE) {
    this.presentAlert("Connection Error","Please check your internet connection.","OK");
    this.syncLoader2 = false;
  }
  else {
    this.syncLoader2 = true;
      this.databaseservice.getLocalTransData('N').then((data: any) => {

        this.ListLocalTransData = data;
        let deviceuuid = this.localservice.getDeviceUUID();
        this.db =  this.databaseservice.getDbConnection();
        let sql_check_mobile = 'SELECT * FROM mobile_master WHERE mobile_uuid = "' + deviceuuid + '" AND mobile_master.is_active="Y"';


        this.db.executeSql(sql_check_mobile, []).then((data) => {
          
          if (data.rows.length > 0) {
            let mobileid = data.rows.item(0).mobile_id;

            let resulStatus;
            this.liveservice.updateLocalTransHistory(mobileid,this.ListLocalTransData).then(data => {
              resulStatus = data;
              if(resulStatus.msg_data=="SUCCESS" && resulStatus.msg_status==200) {
                this.databaseservice.updateLocalTransDataByDriverCode();
                this.syncLoader2 = false;
    
    
              }
              
            });


          }
          else {
          
            this.syncLoader2 = false;
          }
        
        }, (error) => {
          
          //reject(error);
        })

  
    
      }, (error) => {
      console.log(error);
    })
  }

  


}

}// end of class
