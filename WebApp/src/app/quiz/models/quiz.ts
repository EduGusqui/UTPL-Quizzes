import { User } from '../../users/models/user';

export class Quiz {
	constructor(
		public Id?: number,
		public Name?: string,
		public AttemptNumber?: number,
		public Status?: string,
		public User?: User
	) {}
}