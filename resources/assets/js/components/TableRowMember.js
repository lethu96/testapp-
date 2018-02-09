import React, { Component } from 'react';
import { Link, browserHistory, Image } from 'react-router';
import MyGlobalSettings from './MyGlobalSettings';



class TableRowMember extends Component
{
    constructor(props)
    {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(event)
    {
        event.preventDefault();
        let uri = MyGlobleSetting.url + '/api/member/${this.props.obj.id}';
        axios.delete(uri);
            browserHistory.push('/display-item-member');
    }

    render()
    {
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
                    {this.props.obj.position.name}
                </td>
                <td>
                    <img width="100px" height="100px" src={this.props.obj.avatar} />
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