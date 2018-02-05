import React, { Component } from 'react';
import { Link, browserHistory } from 'react-router';
import MyGlobleSetting from './MyGlobleSetting';


class TableRow extends Component {
  constructor(props) {
      super(props);
      this.handleSubmit = this.handleSubmit.bind(this);
  }
  handleSubmit(event) {
    event.preventDefault();
    let uri = MyGlobleSetting.url + '/api/project/${this.props.obj.id}';
    axios.delete(uri);
      browserHistory.push('/display-item');
  }
  render() {
    return (
        <tr>
          <td>
            {this.props.obj.id}
          </td>
          <td>
            {this.props.obj.name}
          </td>
          <td>
            {this.props.obj.information}
          </td>
          <td>
            {this.props.obj.deadline}
          </td>
          <td>
            {this.props.obj.type}
          </td>
          <td>
            {this.props.obj.status}
          </td>
          <td>
          <form onSubmit={this.handleSubmit}>
            <Link to={"/edit-item/"+this.props.obj.id} className="btn btn-primary">Edit</Link>
           <input type="submit" value="Delete" className="btn btn-danger"/>
         </form>
          </td>
        </tr>
    );
  }
}


export default TableRow;