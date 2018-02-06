import React, { Component } from 'react';
import { Link, browserHistory } from 'react-router';
import MyGlobleSetting from './MyGlobleSetting';


class TableRowMember extends Component {
  constructor(props) {
      super(props);
      this.handleSubmit = this.handleSubmit.bind(this);
  }
  handleSubmit(event) {
    event.preventDefault();
    let uri = MyGlobleSetting.url + '/api/members/${this.props.obj.id}';
    axios.delete(uri);
      browserHistory.push('/display-item-member');
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
                    {this.props.obj.phone_number}
                </td>
                <td>
                    {this.props.obj.birthday}
                </td>
                <td>
                    {this.props.obj.gender}
                </td>
                <td>
                    {this.props.obj.position_id}
                </td>
                <td>
                    {this.props.obj.avatar}
                </td>
                <td>
                    <form onSubmit={this.handleSubmit}>
                        <Link to={"/edit-item-member/"+this.props.obj.id} className="btn btn-primary">Edit</Link>
                        <input type="submit" value="Delete" className="btn btn-danger"/>
                    </form>
          </td>
        </tr>
    );
  }
}


export default TableRowMember;