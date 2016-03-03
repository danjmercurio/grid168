# == Schema Information
#
# Table name: outlets
#
#  id           :integer(4)      not null, primary key
#  name         :string(255)     not null
#  description  :string(255)
#  subs         :integer(4)      not null
#  dma_id       :integer(4)      not null
#  user_id      :integer(4)      not null
#  created_at   :datetime
#  updated_at   :datetime
#  outlet_type  :integer(4)      default(0), not null
#  first_name   :string(255)
#  last_name    :string(255)
#  phone_number :string(255)
#

require 'test_helper'

class OutletTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
