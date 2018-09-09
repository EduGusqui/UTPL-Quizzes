import { User } from '../../users/models/user';
import { Quiz } from '../../quiz/models/quiz';

export class AssignQuiz {
	constructor(
		public Id?: number,
		public Quiz?: Quiz,
		public Teacher?: User,
		public Students?: User[],
		public Status?: string
	) {}
}