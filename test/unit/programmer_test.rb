# == Schema Information
#
# Table name: programmers
#
#  id          :integer(4)      not null, primary key
#  name        :string(255)
#  description :text
#  created_at  :datetime
#  updated_at  :datetime
#  user_id     :integer(4)
#  first_name  :string(255)
#  last_name   :string(255)
#  email       :string(255)
#  phone       :string(255)
#

require 'test_helper'

class ProgrammerTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
