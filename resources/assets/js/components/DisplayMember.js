import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import TableRow from './TableRow';
import MyGlobleSetting from './MyGlobleSetting';

class DisplayProject extends Component {

    constructor(props) {
        super(props);
        this.state = {value: '', member: ''};
     }
     getInitialState: function(){
        return {
            member: []
        };
     },

    componentDidMount(){
      this.serverRequest = $.get("http://testthu/api/member/list", function (products) {
            this.setState({
                products: products.records
            });
        }.bind(this));
     },
    componentWillUnmount() {
        this.serverRequest.abort();
    },

    tabRow(){
       if(this.state.project instanceof Array){
            return this.state.project.map(function(object, i){
            return i;
         })
       }
     }


    render(){
        return (
            <div>
            <h1>Project</h1>
                <div className="row">
                <div className="col-md-10"></div>
                    <div className="col-md-2">
                    <Link to="/add-item">Create Projects</Link>
                </div>
                </div><br />


        <table className="table table-hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Information</td>
                <td>Deadline</td>
                <td>Type</td>
                <td>Status</td>
                <td width="200px">Actions</td>
            </tr>
            </thead>
            <tbody>
              {this.tabRow()}
            </tbody>
        </table>
    </div>
    )
  }
}
export default DisplayProject;