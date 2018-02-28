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
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                axios.delete('http://localhost:8000/member/destroy/' + this.props.obj.id).then(
                    (response) => {
                        axios.get('http://localhost:8000/member')
                    .then(response => {
                        this.setState({ list: response.data });
                        this.props.newlist(this.state.list)
                    })
                });
                swal("Member has been deleted!", {
                    icon: "success",
                    timer: 1000,
                    buttons:false
                });
            }
        });
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
                <td className="infor">
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
                    <img className="thumb"  src={this.props.obj.avatar} />
                </td>
                <td>
                    <form onSubmit={this.handleSubmit}>
                        <Link to={"/edit-item-member/"+this.props.obj.id} className="btn btn-primary">Edit</Link>
                        <Link to={"/show-item-member/"+this.props.obj.id} className="btn btn-success"> Show </Link>
                        <input type="submit" value="Delete" className="btn btn-danger"/>
                    </form>
                </td>
            </tr>
        );
    }
}
export default TableRowMember;