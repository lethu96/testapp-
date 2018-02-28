import React, { Component } from 'react';
import { Link, browserHistory } from 'react-router';
import swal from 'sweetalert';

class TableRow extends Component
{
    constructor(props)
    {
        super(props);
        this.state={list: ''};
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                axios.delete('http://localhost:8000/project/destroy/' + this.props.project.id).then(
                    (response) => {
                        axios.get('http://localhost:8000/project')
                    .then(response => {
                        this.setState({ list: response.data });
                        this.props.newlist(this.state.list)
                    })
                });
                swal("Project has been deleted!", {
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
                    {this.props.project.id}
                </td>
                <td>
                    {this.props.project.name}
                </td>
                <td>
                    {this.props.project.information}
                </td>
                <td>
                    {this.props.project.deadline}
                </td>
                <td>
                    {this.props.project.type}
                </td>
                <td>
                    {this.props.project.status}
                </td>
                <td>
                    <form onSubmit={this.handleSubmit}>
                        <Link to={"/edit-item/"+this.props.project.id} className="btn btn-primary">Edit</Link>
                        <Link to={"/show-detail-item/"+this.props.project.id} className="btn btn-success">Show</Link>
                        <input type="submit" value="Delete" className="btn btn-danger"/>
                    </form>
                </td>
            </tr>
        );
    }
}
export default TableRow;