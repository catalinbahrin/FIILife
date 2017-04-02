/**
 * Created by Razvan on 02-Apr-17.
 */
function Student(student){

    this.ID = student['ID'];
    this.name = student['name'];
    this.email = student['email'];

}
function Teacher(teacher){

    this.ID = teacher['ID'];
    this.name = teacher['name'];
    this.email = teacher['email'];

}

function Course(response){
    this.ID = response['ID'];
    this.name = response['name'];
    this.day = response['day'];
    this.description = response['description'];

}