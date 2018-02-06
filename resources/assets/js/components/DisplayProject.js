import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import TableRow from './TableRow';

class DisplayProject extends Component {
  constructor(props) {
       super(props);
       this.state = {value: '', project: ''};
     }
     componentDidMount(){
       axios.get('http://localhost:8000/project')
       .then(response => {
         this.setState({ project: response.data });
       })
       .catch(function (error) {
         console.log(error);
       })
     }
     tabRow(){
       if(this.state.project instanceof Array){
         return this.state.project.map(function(object, i){
             return <TableRow obj={object} key={i} />;
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